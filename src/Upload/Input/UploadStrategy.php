<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 18:58
 */

namespace xiio\xUpload\Upload\Input;

use xiio\xUpload\Upload\Abstraction\UploadStrategyInterface;

abstract class UploadStrategy implements UploadStrategyInterface
{

    protected $key;
    protected $rawInput;

    public function __construct($key)
    {
        if ($this->keyExists($key)) {
            $exceptionMessage = 'Key ' . $key . ' not found in uploaded files. Check the name and try again.';
            throw new \InvalidArgumentException($exceptionMessage);
        }

        $this->key = $key;
        $this->rawInput = $_FILES[ $key ];
        $this->processInput();
    }

    protected function keyExists($key)
    {
        return !isset($_FILES[ $key ]);
    }

    /**
     * @return array of \xiio\xUpload\File
     */
    abstract public function getFiles();

    /**
     * @param                         $key
     *
     * @return \xiio\xUpload\Upload\Abstraction\UploadStrategyInterface
     */
    public static function getUploadStrategy($key)
    {
        if (!isset($_FILES[ $key ])) {
            throw new \InvalidArgumentException('Missing key '.$key.' in $_FILES!');
        }
        if (is_array($_FILES[ $key ]['name'])) {
            $result = new UploadMulti($key);
        } else {
            $result = new UploadSingle($key);
        }

        return $result;
    }

    abstract protected function processInput();
}
