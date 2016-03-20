<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 18:43
 */

namespace xiio\xUpload\Storage\Abstraction;

use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Storage\StoreDestination;

interface StorageRepositoryInterface
{

    public function beforeStore($callback);

    public function delete(File $file);

    public function exists(File $file);

    /**
     * @param \xiio\xUpload\Abstraction\File         $file
     * @param \xiio\xUpload\Storage\StoreDestination $where
     *
     * @param bool                                   $force if TRUE existing files will be override
     *
     * @return \xiio\xUpload\Abstraction\File
     */
    public function store(File $file, StoreDestination $where, $force = false);
}
