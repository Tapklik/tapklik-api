<?php namespace Tapklik\Uploader\Contracts;

interface CanUnzipFiles
{
    public function unzip(string $file, string $location);
}
