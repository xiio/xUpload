<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 23:27
 */

namespace xiio\xUpload\Storage;

class StoreDestination
{

    private $filename;
    private $destinationDir;

    /**
     * StoreDestination constructor.
     *
     * @param $filename
     * @param $destinationDir
     */
    public function __construct($filename, $destinationDir = '')
    {
        $this->filename = $filename;
        $this->destinationDir = $destinationDir;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getDestinationDir()
    {
        return $this->destinationDir;
    }

    /**
     * @param string $destinationDir
     */
    public function setDestinationDir($destinationDir)
    {
        $this->destinationDir = $destinationDir;
    }

    public function getDestinationPath()
    {
        return $this->getDestinationDir() . DIRECTORY_SEPARATOR . $this->getFilename();
    }
}
