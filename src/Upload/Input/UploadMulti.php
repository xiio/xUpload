<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 18:49
 */

namespace xiio\xUpload\Upload\Input;

class UploadMulti extends GlobalFilesUploadStrategy
{

    /**
     * @var  \xiio\xUpload\Upload\Abstraction\IncomingFileInterface[]
     */
    private $files = [];

    protected function processInput()
    {
        $filesCount = count($this->rawInput['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            $this->files[] = new IncomingFile(
                $this->rawInput['name'][ $i ],
                $this->rawInput['tmp_name'][ $i ]
            );
        }
    }

    /**
     * @return  \xiio\xUpload\Upload\Abstraction\IncomingFileInterface[]
     */
    public function getFiles()
    {
        return $this->files;
    }
}
