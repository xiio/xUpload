<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-15
 * Time: 20:12
 */

namespace xiio\xUpload\Validation\Rules;

use xiio\xUpload\Abstraction\File;

class ExtensionRule extends ValidationRule
{

    public function __construct($rule, $errorMsg = 'Wrong file extension!')
    {
        if (!is_array($rule)) {
            $rule = [$rule];
        }
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
        $extension = pathinfo($file->getPath(), PATHINFO_EXTENSION);
        $allowedExtensions = $this->rule;
        return in_array($extension, $allowedExtensions);
    }
}
