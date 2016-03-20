<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 18:40
 */

namespace xiio\xUpload;

use xiio\xUpload\Upload\UploadError;
use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface;
use xiio\xUpload\Storage\StoreDestination;
use xiio\xUpload\Storage\StoredFile;
use xiio\xUpload\Upload\Abstraction\InputSourceInterface;
use xiio\xUpload\Upload\Input\FilesInputSource;
use xiio\xUpload\Validation\Abstraction\ValidatorInterface;
use xiio\xUpload\Validation\Validator;

class xUpload
{

    /**
     * Provide for readability of code
     */
    const OVERRIDE_EXITING_FILES = true;

    /**
     * @var \xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface
     */
    private $storage;

    /**
     * @var \xiio\xUpload\Upload\Abstraction\InputSourceInterface
     */
    private $source;

    /**
     * @var \SplObjectStorage
     */
    private $errors;

    /**
     * @var StoredFile[]
     */
    private $storedFiles = [];

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var bool
     */
    private $isUploadValid = null;

    /**
     * xUpload constructor.
     *
     * @param \xiio\xUpload\Upload\Abstraction\InputSourceInterface        $source default FilesInputSource ($_FILES)
     * @param \xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface $storage
     * @param \xiio\xUpload\Validation\Abstraction\ValidatorInterface      $validator
     */
    public function __construct(
        InputSourceInterface $source,
        StorageRepositoryInterface $storage,
        ValidatorInterface $validator = null
    ) {
        $this->storage = $storage;
        $this->source = $source;
        $this->initialize($validator);
    }

    private function initialize(ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            $validator = new Validator();
        }
        $this->validator = $validator;
        $this->errors = new \SplObjectStorage();
    }

    /**
     * Create xUpload with initialized $_FILES input source
     *
     * @param  string                                                      $key key in $_FILES array
     * @param \xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface $storage
     *
     * @return \xiio\xUpload\xUpload
     */
    public static function fromFiles($key, StorageRepositoryInterface $storage)
    {
        $source = new FilesInputSource($key);

        return new self($source, $storage);
    }

    /**
     * Get files that were stored/saved
     * @return StoredFile[]
     */
    public function getUploadedFiles()
    {
        return $this->storedFiles;
    }

    /**
     * Get current uploading files.
     * @return \xiio\xUpload\Upload\Abstraction\IncomingFileInterface[]
     */
    public function getUploadingFiles()
    {
        return $this->source->getFiles();
    }

    /**
     * Store valid uploading files (using configured storage).
     *
     * @param string $destinationPath Specify save path relative to storage root or leave empty to save in storage root
     *
     * @param bool   $force           if TRUE existing files will be override
     *
     * @return \xiio\xUpload\Storage\StoredFile[]
     */
    public function storeValidFiles($destinationPath = '', $force = false)
    {
        $files = $this->getUploadingFiles();
        /** @var File $file */
        foreach ($files as $file) {
            $fileErrors = $this->getFileErrors($file);
            if (empty($fileErrors)) {
                $where = new StoreDestination(
                    $file->getName(),
                    $destinationPath
                );
                $this->storedFiles[] = $this->storage->store($file, $where, $force);
            } else {
                $this->errors[$file] = $fileErrors;
            }
        }

        return $this->storedFiles;
    }

    /**
     * Remove temporary files (incoming files) from disk
     */
    public function flush()
    {
        // TODO
    }

    /**
     * Check if upload is valid (check all files). If there are errors you can get it by calling getErrors() method
     * @return boolean
     */
    public function isValid()
    {
        if (null !== $this->isUploadValid) {
            return $this->isUploadValid;
        }
        $this->resetErrors();
        $files = $this->getUploadingFiles();
        $valid = true;
        /** @var File $file */
        foreach ($files as $file) {
            $fileErrors = $this->getFileErrors($file);
            if (!empty($fileErrors)) {
                $this->errors[ $file ] = $fileErrors;
                $valid = false;
            }
        }
        $this->isUploadValid = $valid;

        return $valid;
    }

    /**
     * Validate single file and return errors;
     *
     * @param \xiio\xUpload\Abstraction\File $file
     *
     * @return false|\spec\xiio\xUpload\Upload\UploadError
     */
    public function getFileErrors(File $file)
    {
        $errors = [];

        if (!$this->validation()->isValid($file)) {
            $errors = $this->validation()->getErrors();
        }

        return $errors;
    }

    private function resetErrors()
    {
        $this->errors = [];
    }

    /**
     * Get validator
     * @return \xiio\xUpload\Validation\Abstraction\ValidatorInterface
     */
    public function validation()
    {
        return $this->validator;
    }

    /**
     * @return UploadError[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
