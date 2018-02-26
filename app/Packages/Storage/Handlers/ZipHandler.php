<?php namespace Tapklik\Storage\Handlers;

use Symfony\Component\HttpFoundation\File\File;
use Tapklik\Storage\Contracts\AbstractStorageAdapter;
use Tapklik\Storage\Contracts\FileHandlerInterface;
use Tapklik\Uploader\Contracts\UploaderInterface;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;

/**
 * Class ZipHandler
 *
 * @package \\${NAMESPACE}
 */
class ZipHandler implements FileHandlerInterface
{

	/**
	 * @param \Symfony\Component\HttpFoundation\File\File $file
	 *
	 * @param \Tapklik\Storage\Contracts\AbstractStorageAdapter $uploader
	 *
	 * @return \Tapklik\Storage\Handlers\Array
	 */
	public function handle(File $file, AbstractStorageAdapter $uploader): Array
	{

		try {
			$uploader->getStorageDriver()->uploadDirectory(
				public_path(str_replace('.zip', '', $file->getPathname())),
				getenv('AWS_BUCKET'),
				'creatives/html5/' . $file->getFilename()
			);


			$localZipFileLocation = url('trunk' . str_replace('./trunk', '', $file->getPathname()));
			$uploadedFileLocation = 'http://comtapklik.s3.amazonaws.com/creatives/html5/' . $file->getFilename();

			return [
				'iurl'  => $uploadedFileLocation . '/index.jpg',
				'asset' => $localZipFileLocation,
				'thumb' => $uploadedFileLocation . '/index.jpg',
				'html'  => $uploadedFileLocation . '/index.html'
			];
		} catch (S3Exception $e) {

			throw new TapklikUploaderException($e->getMessage(), $e->getCode());
		}
	}

	private function _getMainHtmlFile(string $filePath)
	{

		try {
			return $this->_extract($filePath);
		} catch (\Exception $e) {
			\Log::info($e->getMessage());
		}


    	    // Extract zip
		// Open dir folder check for first html
		// Return html name
	}

	private function _extract(string $filePath) {

		$tempDir = './public/tmp/' . sha1(time() . rand(99999, 9999999));

		$zip = new \ZipArchive();

		if($zip->open($filePath) === true)
		{
			$zip->extractTo($tempDir);
			$zip->close();

			return $this->_scanDir($tempDir);
		} else {

			throw new TapklikUploaderException('Could not extract the zip file');
		}
	}

	private function _scanDir(string $dir)
	{
		$itterator = new \DirectoryIterator($dir);

		$itterator->each( function ($item) {
			echo $item;
		});
	}
}
