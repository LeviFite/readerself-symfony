<?php
namespace Readerself\CoreBundle\Event;

use Readerself\CoreBundle\Entity\ItemCategory;
use Symfony\Component\EventDispatcher\Event;

class ItemCategoryEvent extends Event
{
    protected $data;

    protected $mode;

    public function __construct(ItemCategory $data, $mode)
    {
        $this->data = $data;
        $this->mode = $mode;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMode()
    {
        return $this->mode;
    }
}
