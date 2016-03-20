<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 23:33
 */

namespace xiio\xUpload\Storage\Abstraction;

interface EventInterface
{

    /**
     * @return \xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface
     */
    public function getSender();
}
