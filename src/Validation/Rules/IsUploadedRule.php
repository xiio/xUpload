<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-15
 * Time: 20:12
 */

namespace xiio\xUpload\Validation\Rules;

use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Validation\Abstraction\ValidationRuleInterface;

/**
 * Tells whether the file was uploaded via HTTP POST
 *
 * @see     http://php.net/manual/en/function.is-uploaded-file.php
 * @package xiio\xUpload\Validation\Rules
 */
class IsUploadedRule implements ValidationRuleInterface
{

    private $errorMessage;

    /**
     * IsUploadedRule constructor.
     *
     * @param string $errorMessage
     */
    public function __construct($errorMessage = "File is'n uploaded via HTTP POST!")
    {
        $this->errorMessage = $errorMessage;
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
        return is_uploaded_file($file->getPath());
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
