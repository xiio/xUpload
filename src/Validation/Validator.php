<?php

namespace xiio\xUpload\Validation;

use xiio\xUpload\Upload\UploadError;
use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Validation\Abstraction\ValidationRuleInterface;
use xiio\xUpload\Validation\Abstraction\ValidatorInterface;
use xiio\xUpload\Validation\Rules\ValidationRule;

class Validator implements ValidatorInterface
{

    /**
     * @var ValidationRule[]
     */
    private $rules = [];

    /**
     * @var UploadError[]
     */
    private $errors;

    public function addRule(ValidationRuleInterface $rule)
    {
        $this->rules[] = $rule;
        $this->errors = new \SplObjectStorage();
    }

    public function isValid(File $file)
    {
        $valid = true;
        $this->resetErrors();
        foreach ($this->rules as $rule) {
            $isRuleValid = $rule->isValid($file);
            if (!$isRuleValid) {
                $this->errors = new UploadError($rule);
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * return validation errors
     * @return UploadError[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    private function resetErrors()
    {
        $this->errors = [];
    }

    public function getRules()
    {
        return $this->rules;
    }
}
