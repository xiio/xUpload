<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-15
 * Time: 20:12
 */

namespace xiio\xUpload\Validation\Rules;

use xiio\xUpload\Abstraction\File;

class SizeRule extends ValidationRule
{

    public function __construct($rule, $errorMsg = 'File is too large!')
    {
        parent::__construct($rule, $errorMsg);
    }

    /**
     * Validate file
     *
     * @param \xiio\xUpload\Abstraction\File $file
     *
     * @return bool
     */
    public function isValid(File $file)
    {
        $maxFileSize = $this->rule;
        $fileSize = filesize($file->getPath()) / 1024;//KB
        return $fileSize <= $maxFileSize;
    }
}
