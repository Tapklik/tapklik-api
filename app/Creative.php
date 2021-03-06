<?php namespace App;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Http\Request;

/**
 * Class Creative
 *
 * @package App
 */
class   Creative extends ModelSetup implements Uuidable
{

	private static $_s3 = false;

	// Methods
	public static function generateAdm($campaignId, $creativeId, $type = '')
	{

		$creative = self::findByUuId($creativeId);

		switch ($type) {
			case 'iframe':
				$type = ($creative->class == 'html5') ? 'type=html5&' : '';

				return "<iframe src='{{IMP_PATH}}&{{ADM_URL}}' marginwidth='0' marginheight='0' align='top' scrolling='no' frameborder='0' hspace='0' vspace='0'  height='{$creative->h}' width='{$creative->w}'></iframe>";
				break;

			case 'js':
				return "<script type='text/javascript'>
                        (function() {
                            var dlvr_u = '{{ADM_URL}}';
                            var dlvr_hsh = Math.floor(Math.random() * 999999);
                    
                            document.write('<script type=\"text/javascript\" src=\"' + dlvr_u);
                            document.write('?cid={$creativeId}');
                    
                                    document.write('&hashid=' + dlvr_hsh);
                                    
                            if(document.referrer) document.write('&ref=' + encodeURI(document.referrer));
                            
                            document.write('\"><\/script>');
                        })();";
				break;

			case 'url':
				return env('AD_SERVER_URL') . '/link/' . $creativeId;
				break;

			default:
				return '<script language="javascript" src="{{IMP_PATH}}"></script><a href="{{ADM_URL}}" target="_blank" style="display: block; overflow: hidden; height: auto !important;"><img src="' . $creative->iurl . '" alt="bann_' . rand(9999, 99999) . '"></a>';
				break;
		}

	}

	/**
	 * @param string $uuid
	 *
	 * @return mixed
	 */
	public static function findByUuId(string $uuid)
	{

		return self::where(['uuid' => $uuid])->firstOrFail();
	}

	public static function findByAccountId($id) {
		
		return Creative::selectRaw('creatives.*, accounts.uuid as account_uuid')
		->join('folders','folders.id','=','creatives.folder_id')
		->join('accounts', 'accounts.id', '=', 'folders.account_id')
		->where(['accounts.uuid' => $id])
		->get();
	}

	public function campaign()
	{

		return $this->belongsToMany(Campaign::class);
	}

	public static function newCreative($payload = [])
	{
		$payload['expdir'] = 0;
		$payload['adm'] = '';

		return self::create($payload);
	}

	public static function replaceHtml5ClickTag(Creative $creative)
	{

		self::$_s3 = S3Client::factory(
			[
				'region'      => getenv('AWS_REGION'),
				'version'     => '2006-03-01',
				'credentials' => [
					'key'    => getenv('AWS_ACCESS_KEY'),
					'secret' => getenv('AWS_SECRET_KEY')]]
		);

		$campaign = $creative->campaign()->first();
		$object = self::_getObjectAttributesForAws($creative->iurl);
		$iurl = str_replace('.html', '.jpg', $object['url']);

		try {
			self::_downloadFile($object);
			$replacedHTML = self::_replaceClickTagUrl(public_path('/trunk/' . $object['fileName']), $iurl);

			self::_uploadFile($object, $replacedHTML);
		} catch (\Exception $e) {
			\Log::error('Error with HTML5 AD and s3: ' . $e->getMessage());
		}
	}

	private static function _getObjectAttributesForAws(string $url)
	{

		$segments = collect(explode('/', $url));
		$bucket = $segments->offsetGet(3);
		$object = $segments->last();
		$key = $segments->each(
			function ($segment, $index) use ($segments) {

				if ($index <= 3) {
					$segments->offsetUnset($index);
				}

				return $segment;
			}
		)->implode('/');

		return [
			'url'      => $url,
			'bucket'   => $bucket,
			'key'      => $key,
			'fileName' => $object,];
	}

	private static function _downloadFile(array $object = [])
	{

		try {
			self::$_s3->getObject(
				[
					'Bucket' => $object['bucket'],
					'Key'    => $object['key'],
					'SaveAs' => public_path('/trunk/' . $object['fileName'])]
			);
		} catch (S3Exception $e) {
			throw new \Exception($e->getMessage(), $e->getCode());
		}
	}

	private static function _replaceClickTagUrl(string $file, string $url = '')
	{

		$html = file_get_contents($file);
		$patt = '/clickTag ?= ?+[\'"](.*)+[\'"]/';

		preg_match($patt, $html, $matches);

		if (!$matches) {
			return $html;
		}

		$html = str_replace($matches[0], "clickTag = '{$url}'", $html);

		return $html;
	}

	private static function _uploadFile(array $object, string $html, $acl = 'public-read-write')
	{

		try {

			$result = self::$_s3->putObject(
				[
					'ACL'    => $acl,
					'Bucket' => $object['bucket'],
					'Key'    => $object['key'],
					'Body'   => $html]
			);

			dd($result);
		} catch (S3Exception $e) {
			throw new \Exception($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function folder()
	{

		return $this->belongsTo(Folder::class);
	}

	public function attributes()
	{

		return $this->hasMany(Attribute::class);
	}

	public function makeCreative($object = [])
	{

		return new self($object);
	}

	public function clearAttributes()
	{
		$this->attributes()->each(function ($attribute) {
			$attribute->delete();
		});
	}
}
