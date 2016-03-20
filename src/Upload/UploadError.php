<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-20
 * Time: 09:32
 */

namespace xiio\xUpload\Upload;

use xiio\xUpload\Validation\Rules\ValidationRule;

class UploadError
{

    /**
     * @var ValidationRule
     */
    private $rule;

    /**
     * UploadError constructor.
     *
     * @param                       $rule
     */
    public function __construct($rule)
    {
        $this->rule = $rule;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->rule->getErrorMessage();
    }

    /**
     * Get rule which cause the error
     * @return ValidationRule
     */
    public function getRule()
    {
        return $this->rule;
    }
}
