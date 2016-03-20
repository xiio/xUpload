<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-12
 * Time: 21:02
 */
namespace xiio\xUpload\Upload\Abstraction;

interface InputSourceInterface
{
    /**
     * Return files that are uploaded
     * @return IncomingFileInterface[]
     */
    public function getFiles();
}
