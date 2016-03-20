<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 22:46
 */
namespace xiio\xUpload\Abstraction;

interface File
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
}
