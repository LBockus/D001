<?php

namespace App;

class FS
{
    private string $fileContent;

    public function __construct(private string $fileName)
    {
        $this->fileContent = file_get_contents($this->fileName);
    }

    public function getFileContent(): string
    {
        return $this->fileContent;
    }
}