<?php

namespace Paysera;


class FileReader
{
    /** @var resource */
    private $handle;

    /**
     * FileReader constructor.
     * @param $fileName
     * @throws \Exception
     */
    public function __construct($fileName)
    {
        $this->handle = @fopen($fileName, "r");
        if (!$this->handle) {
            throw new \Exception('File not found: ' . $fileName);
        }
    }

    /**
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @return bool
     */
    public function close()
    {
        return fclose($this->handle);
    }
}
