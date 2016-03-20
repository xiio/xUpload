<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-05
 * Time: 08:45
 */

namespace xiio\xUpload\Storage\Exceptions;

class FileExistsException extends \Exception
{

    private $filePath;

    /**
     * FileExistException constructor.
     *
     * @param string $filePath
     *
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getExistingFilePath()
    {
        return $this->filePath;
    }
}
