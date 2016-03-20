<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-15
 * Time: 20:12
 */

namespace xiio\xUpload\Validation\Rules;

use xiio\xUpload\Abstraction\File;

/**
 * Validation rule to check mime type of a file.
 * It's based on finfo function and FILEINFO_MIME_TYPE constant.
 *
 * @see     http://php.net/manual/en/function.finfo-file.php
 * @package xiio\xUpload\Validation\Rules
 */
class MimeTypeRule extends ValidationRule
{

    private $mimetype;

    /**
     * MimeTypeRule constructor.
     *
     * @param string|string[] $rule
     * @param string          $errorMsg
     */
    public function __construct($rule, $errorMsg = 'Wrong file type!')
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
        $fileMimeType = $this->getMimeType($file);
        $allowedMimetypes = $this->rule;

        return in_array($fileMimeType, $allowedMimetypes);
    }

    private function getMimeType(File $file)
    {
        if ($this->mimetype === null) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $this->mimetype = finfo_file($finfo, $file->getPath());
            finfo_close($finfo);
        }

        return $this->mimetype;
    }
}
