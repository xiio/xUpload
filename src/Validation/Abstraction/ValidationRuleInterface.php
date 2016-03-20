<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-15
 * Time: 18:48
 */

namespace xiio\xUpload\Validation\Abstraction;

use xiio\xUpload\Abstraction\File;

interface ValidationRuleInterface
{

    /**
     * Validate file
     *
     * @param \xiio\xUpload\Abstraction\File $file
     *
     * @return bool
     */
    public function isValid(File $file);

    public function getErrorMessage();
}
