<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-15
 * Time: 20:13
 */

namespace xiio\xUpload\Validation\Rules;

use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Validation\Abstraction\ValidationRuleInterface;

abstract class ValidationRule implements ValidationRuleInterface
{

    protected $errorMsg;
    /**
     * @var
     */
    protected $rule;

    /**
     * ValidationRule constructor.
     *
     * @param $rule
     * @param $errorMsg
     */
    public function __construct($rule, $errorMsg = 'Validation fail')
    {
        $this->errorMsg = $errorMsg;
        $this->rule = $rule;
    }

    /**
     * Validate file
     *
     * @param \xiio\xUpload\Abstraction\File $file
     *
     * @return bool
     */
    abstract public function isValid(File $file);

    public function getErrorMessage()
    {
        return $this->errorMsg;
    }
}
