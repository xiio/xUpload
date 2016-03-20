<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 22:46
 */
namespace xiio\xUpload\Upload\Abstraction;

interface IncomingFileInterface
{
//methods
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getPath();

    /**
     * Check if file is uploaded via HTTP POST
     * @see http://php.net/manual/en/function.is-uploaded-file.php
     * @return boolean
     */
    public function isUploaded();
}
