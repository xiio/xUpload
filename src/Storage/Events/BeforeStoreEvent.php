<?php
/**
 * Created by PhpStorm.
 * User: Tomasz
 * Date: 2016-03-04
 * Time: 23:33
 */

namespace xiio\xUpload\Storage\Events;

use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Storage\Abstraction\EventInterface;
use xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface;
use xiio\xUpload\Storage\StoreDestination;

class BeforeStoreEvent implements EventInterface
{

    /**
     * @var \xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface
     */
    private $sender;
    /**
     * @var \xiio\xUpload\Abstraction\File
     */
    private $file;
    /**
     * @var \xiio\xUpload\Storage\StoreDestination
     */
    private $where;

    /**
     * BeforeStoreEventInterface constructor.
     *
     * @param \xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface $sender
     * @param \xiio\xUpload\Abstraction\File                               $file
     * @param \xiio\xUpload\Storage\StoreDestination                       $where
     */
    public function __construct(StorageRepositoryInterface $sender, File $file, StoreDestination $where)
    {
        $this->sender = $sender;
        $this->file = $file;
        $this->where = $where;
    }

    /**
     * @return \xiio\xUpload\Storage\Abstraction\StorageRepositoryInterface
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return \xiio\xUpload\Storage\StoreDestination
     */
    public function getWhere()
    {
        return $this->where;
    }

    public function setWhere(StoreDestination $where)
    {
        $this->where = $where;
    }
}
