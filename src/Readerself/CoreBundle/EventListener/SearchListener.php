<?php
namespace Readerself\CoreBundle\EventListener;

use Readerself\CoreBundle\Manager\SearchManager;
use Readerself\CoreBundle\Manager\ItemManager;

use Readerself\CoreBundle\Event\AuthorEvent;
use Readerself\CoreBundle\Event\CategoryEvent;
use Readerself\CoreBundle\Event\FeedEvent;
use Readerself\CoreBundle\Event\ItemEvent;

class SearchListener
{
    protected $searchManager;

    protected $itemManager;

    public function __construct(
        SearchManager $searchManager,
        ItemManager $itemManager
    ) {
        $this->searchManager = $searchManager;
        $this->itemManager = $itemManager;
    }

    public function removeAuthor(AuthorEvent $authorEvent)
    {
        $action = 'DELETE';
        $path = '/'.$this->searchManager->getIndex().'_author/doc/'.$authorEvent->getdata()->getId();
        $this->searchManager->query($action, $path);
    }

    public function removeCategory(CategoryEvent $categoryEvent)
    {
        $action = 'DELETE';
        $path = '/'.$this->searchManager->getIndex().'_category/doc/'.$categoryEvent->getdata()->getId();
        $this->searchManager->query($action, $path);
    }

    public function removeFeed(FeedEvent $feedEvent)
    {
        $parameters = [];
        $parameters['feed'] = (int) $feedEvent->getdata()->getId();
        $parameters['sortField'] = 'itm.id';
        $parameters['sortDirection'] = 'ASC';
        foreach($this->itemManager->getList($parameters)->getResult() as $item) {
            $action = 'DELETE';
            $path = '/'.$this->searchManager->getIndex().'_item/doc/'.$item['id'];
            $this->searchManager->query($action, $path);
        }

        $action = 'DELETE';
        $path = '/'.$this->searchManager->getIndex().'_feed/doc/'.$feedEvent->getdata()->getId();
        $this->searchManager->query($action, $path);
    }

    public function removeItem(ItemEvent $itemEvent)
    {
        $action = 'DELETE';
        $path = '/'.$this->searchManager->getIndex().'_item/doc/'.$itemEvent->getdata()->getId();
        $this->searchManager->query($action, $path);
    }
}
