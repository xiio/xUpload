<?php

namespace xiio\xUpload\Upload\Input;

use xiio\xUpload\Upload\Abstraction\InputSourceInterface;

class FilesInputSource implements InputSourceInterface
{

    /**
     * Name of key in $_FILES
     * @var string
     */
    private $key;
    /**
     * @var \xiio\xUpload\Upload\Abstraction\UploadStrategyInterface
     */
    private $strategy;

    /**
     * FilesInputSource constructor.
     *
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
        $this->strategy = UploadStrategy::getUploadStrategy($key);
    }

    /**
     * @return \xiio\xUpload\Upload\Abstraction\IncomingFileInterface[]
     */
    public function getFiles()
    {
        return $this->strategy->getFiles();
    }
}
