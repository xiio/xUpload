<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 18:49
 */

namespace xiio\xUpload\Upload\Input;

class UploadSingle extends GlobalFilesUploadStrategy
{
    /**
     * @var \xiio\xUpload\Abstraction\File
     */
    protected $file;

    /**
     * @return \xiio\xUpload\Abstraction\File
     */
    public function getFile()
    {
        return $this->file;
    }

    protected function processInput()
    {
        $this->file = new IncomingFile(
            $this->rawInput['name'],
            $this->rawInput['tmp_name']
        );
    }

    /**
     * @return  \xiio\xUpload\Upload\Abstraction\IncomingFileInterface[]
     */
    public function getFiles()
    {
        return [$this->file];
    }
}
