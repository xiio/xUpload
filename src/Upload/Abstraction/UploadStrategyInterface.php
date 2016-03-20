<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 19:02
 */

namespace xiio\xUpload\Upload\Abstraction;

interface UploadStrategyInterface
{

    /**
     * Get files from upload
     * @return \xiio\xUpload\Upload\Abstraction\IncomingFileInterface[]
     */
    public function getFiles();
}
