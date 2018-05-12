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
	protected $directories = [];

	public function handle(File $file, AbstractStorageAdapter $uploader): array
	{

		try {
			$uploader->getStorageDriver()->uploadDirectory(
				public_path(str_replace('.zip', '', $file->getPathname())),
				getenv('AWS_BUCKET'),
				'creatives/h/' . $file->getFilename(),
                'public-read'
			);


			$localZipFileLocation = url('trunk' . str_replace('./trunk', '', $file->getPathname()));
			$uploadedFileLocation = env('CREATIVES_PATH') . '/h/' . $file->getFilename();
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

	private function _scanDir(string $mainDir)
	{
		$mainFile = $this->_checkForMainHtmlFile($mainDir);

		if(!$mainFile) {

			$this->_checkForDirectories($mainDir)->each(function ($subDir) use ($mainDir, &$mainFile) {
				$result = $this->_checkForMainHtmlFile($mainDir . '/' . $subDir);

				if(strlen($result) > 0) $mainFile = $subDir . '/' . $result;
			});
		}

		return $mainFile;

	}

	private function _checkForMainHtmlFile(string $dir) {
		$collection = scandir($dir);

		$payload = collect($collection)->filter(function($item) {

			return strpos($item, '.html');
		})->flatten()->first();

		return (is_null($payload)) ? '' : $payload;
	}

	private function _checkForDirectories(string $dir) {
		$collection = scandir($dir);

		collect($collection)->each(function ($item) use ($dir) {
			if($item != '.' && $item != '..') {
				if(is_dir($dir . '/' . $item)) {
					array_push($this->directories, $item);
				}
			}
		});

		return collect($this->directories);
	}
}
