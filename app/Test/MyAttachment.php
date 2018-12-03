<?php
namespace App\Test;

class MyAttachment
{
    public $filePath;

    public $fileName;

    public function __construct($path, $name)
    {
        $this->fileName = $name;
        $this->filePath = $path;

    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return "MyAttachment";
    }

}