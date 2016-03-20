<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 18:38
 */

namespace xiio\xUpload\Storage;

use xiio\xUpload\Abstraction\File;

class StoredFile implements File
{

    private $name;
    private $path;

    /**
     * File constructor.
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->name = pathinfo($this->path, PATHINFO_BASENAME);
    }

//methods
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}
