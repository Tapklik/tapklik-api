<?php namespace Tapklik\Storage\Handlers;

use Log;
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

	private function _cleanFileName(string $filename)
	{
		$remove = collect(['X', 'x', '_', '-', '/', '\\']);

		$remove->each(function ($character) use (&$filename) {
			$filename = str_replace($character, '', $filename);
		});

		return $filename;
	}

	private function _getMainHtmlFile(string $filePath)
	{

		try {
			return $this->_extract($filePath);
		} catch (\Exception $e) {
			Log::info($e->getMessage());
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

			$mainFile = $this->_scanDir($tempDir);

			if($mainFile) return $mainFile;
		} else {

			throw new TapklikUploaderException('Could not extract the zip file');
		}
	}

	private function _scanDir(string $dir)
	{

		return $this->_iterate($dir);
	}

	private function _iterate($dir) {

		$collection = scandir($dir);
		$mainHtmlFile  = '';

		$file = collect($collection)->filter(function ($item) use ($dir, &$mainHtmlFile) {

			if($item != '.' && $item != '..') {

				if(is_dir($dir . '/' . $item)) {
					$this->_iterate($dir . '/' . $item);
				}

				if(strpos($item, '.html') > 0 && strpos($item, '._') === false) {
					if(is_file($dir . '/' . $item)) {
						return $item;
					}
				}
			}
		})->flatten();


		return ($file->first() !== NULL) ? $file : '';
	}
}
