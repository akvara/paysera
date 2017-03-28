<?php

namespace Paysera\IO;


/**
 * Class FileReader
 * @package Paysera\IO
 */
class FileReader
{
    /** @var resource */
    private $handle;

    /**
     * FileReader constructor.
     *
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
     * Returns file handle
     *
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Closes file
     *
     * @return bool
     */
    public function close()
    {
        return fclose($this->handle);
    }
}
