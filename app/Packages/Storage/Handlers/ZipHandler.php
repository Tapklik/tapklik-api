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
			$uploadedFileLocation = 'https://comtapklik.s3.amazonaws.com/creatives/html5/' . $file->getFilename();
			$localFileToExtract = str_replace('./', '/', $file->getPathname());

			$mainHtmlFile = $this->_getMainHtmlFile($localFileToExtract);

			return [
				'iurl'  => $uploadedFileLocation . '/' . str_replace('.html', '', $mainHtmlFile) . '.jpg',
				'asset' => $localZipFileLocation,
				'thumb' => $uploadedFileLocation . '/' . str_replace('.html', '', $mainHtmlFile) . '.jpg',
				'html'  => $uploadedFileLocation . '/' . $mainHtmlFile
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


	}

	private function _extract(string $filePath) {
		$filePath = public_path($filePath);

		$tempDir = str_replace('.zip', '', $filePath);

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

		$content = scandir($dir);

		foreach($content as $file) {
			if($file == '.' || $file == '..') continue;

			if(strpos($file, '.html') >= 0) return $file;
		}

		return '';
	}
}
