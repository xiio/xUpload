<?php

namespace xiio\xUpload\Storage;

use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Storage\Abstraction\EventInterface;
use xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface;
use xiio\xUpload\Storage\Events\BeforeStoreEvent;
use xiio\xUpload\Storage\Exceptions\FileExistsException;
use xiio\xUpload\Storage\Exceptions\NotFoundException;

/**
 * Stores file locally
 * Class LocalStorageInterface
 * @package xUpload\Storage
 */
class LocalStorage implements StorageRepositoryInterface
{

    const EVENT_BEFORE_STORE = 0;

    private $events;

    /**
     * @var string
     */
    private $basePath;

    /**
     * LocalStorageInterface constructor.
     *
     * @param string $basePath
     *
     * @throws \xiio\xUpload\Storage\Exceptions\NotFoundException
     */
    public function __construct($basePath)
    {
        $basePath = $this->truepath($basePath);
        if (!file_exists($basePath)) {
            throw new NotFoundException("Base path '" . $basePath . "' not found. It has to exist.");
        }
        $this->events[ self::EVENT_BEFORE_STORE ] = [];
        $this->basePath = $basePath;
    }

    /**
     * @param \xiio\xUpload\Abstraction\File         $file
     * @param \xiio\xUpload\Storage\StoreDestination $where
     *
     * @param bool                                   $force if TRUE existing files will be override
     *
     * @throws \xiio\xUpload\Storage\Exceptions\FileExistsException
     * @return FALSE|\xiio\xUpload\Storage\StoredFile
     */
    public function store(File $file, StoreDestination $where, $force = false)
    {
        /** @var BeforeStoreEvent $event */
        $event = new BeforeStoreEvent($this, $file, $where);
        $event = $this->triggerEvent(self::EVENT_BEFORE_STORE, $event);
        $where = $event->getWhere();
        $destinationDir = $this->truepath($this->basePath . $where->getDestinationDir());//get real path
        if (!$this->inScope($destinationDir)) {
            throw new \InvalidArgumentException('Destination path "' . $destinationDir . ' is out of storage scope!');
        }
        /* check if real path is in scope */
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir, 755, true);//TODO check permission settings
        }
        $storedFilePath = $this->basePath . $where->getDestinationPath();
        if (file_exists($storedFilePath) && !$force) {
            throw new FileExistsException($storedFilePath);
        }
        $result = rename($file->getPath(), $storedFilePath);
        if ($result) {
            return new StoredFile(realpath($storedFilePath));
        } else {
            return false;
        }
    }

    public function delete(File $file)
    {
        $path = $file->getPath();
        unset($path);
    }

    public function beforeStore($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException("Callback isn't callable.");
        }

        $this->events[ self::EVENT_BEFORE_STORE ][] = $callback;
    }

    public function exists(File $file)
    {
        return file_exists($file->getPath());
    }

    /**
     * Check if given path is in storage scope
     *
     * @param $path
     *
     * @return bool
     */
    public function inScope($path)
    {
        return strpos($path, $this->basePath) !== false;
    }

    /**
     * @param                                                  $eventType
     * @param \xiio\xUpload\Storage\Abstraction\EventInterface $event
     *
     * @return \xiio\xUpload\Storage\Abstraction\EventInterface
     */
    private function triggerEvent($eventType, EventInterface $event)
    {
        foreach ($this->events[ $eventType ] as $callback) {
            $result = call_user_func_array($callback, [$event]);
            if ($result instanceof EventInterface) {
                $event = $result;
            }
        }

        return $event;
    }

    /**
     * This function is to replace PHP's extremely buggy realpath().
     *
     * @param string $path the original path, can be relative etc.
     *
     * @see http://stackoverflow.com/questions/4049856/replace-phps-realpath
     * @return string The resolved path, it might not exist.
     */
    private function truepath($path)
    {
        $isUnixPath = $this->isUnixPath($path);
        $isRelativePath = $this->isRelativePath($path);
        if ($isRelativePath) {
            $path = getcwd() . DIRECTORY_SEPARATOR . $path;
        }
        $path = $this->makePathAbsolute($path);
        $path = $this->resolveSymlink($path);

        // put initial separator that could have been lost
        $path = $isUnixPath ? '/' . $path : $path;

        return $path;
    }

    private function isUnixPath($path)
    {
        return strlen($path) != 0 && $path{0} == '/';
    }

    private function isRelativePath($path)
    {
        return strpos($path, ':') === false && $this->isUnixPath($path);
    }

    private function makePathAbsolute($path)
    {
        $parts = $this->getPathParts($path);
        $absolutes = [];
        foreach ($parts as $part) {
            if ('.' == $part) {
                continue;
            }
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }

        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }

    private function getPathParts($path)
    {
        $normalizedPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        $allParts = explode(DIRECTORY_SEPARATOR, $normalizedPath);
        $significantParts = array_filter($allParts, 'strlen');

        return $significantParts;
    }

    private function resolveSymlink($path)
    {
        if (file_exists($path) && linkinfo($path) > 0) {
            $path = readlink($path);
        }

        return $path;
    }
}
