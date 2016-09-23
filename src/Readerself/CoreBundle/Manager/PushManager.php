<?php
namespace Readerself\CoreBundle\Manager;

use Readerself\CoreBundle\Manager\AbstractManager;
use Readerself\CoreBundle\Entity\Push;
use Readerself\CoreBundle\Event\PushEvent;

use Minishlink\WebPush\WebPush;

class PushManager extends AbstractManager
{
    protected $gcm;

    public function __construct(
        string $gcm
    ) {
        $this->gcm = $gcm;
    }

    public function getOne($paremeters = [])
    {
        return $this->em->getRepository('ReaderselfCoreBundle:Push')->getOne($paremeters);
    }

    public function getList($parameters = [])
    {
        return $this->em->getRepository('ReaderselfCoreBundle:Push')->getList($parameters);
    }

    public function init()
    {
        return new Push();
    }

    public function persist($data)
    {
        if($data->getDateCreated() == null) {
            $mode = 'insert';
            $data->setDateCreated(new \Datetime());
        } else {
            $mode = 'update';
        }
        $data->setDateModified(new \Datetime());

        $this->em->persist($data);
        $this->em->flush();

        $event = new PushEvent($data, $mode);
        $this->eventDispatcher->dispatch('Push.after_persist', $event);

        $this->clearCache();

        return $data->getId();
    }

    public function remove($data)
    {
        $event = new PushEvent($data, 'delete');
        $this->eventDispatcher->dispatch('Push.before_remove', $event);

        $this->em->remove($data);
        $this->em->flush();

        $this->clearCache();
    }

    public function start()
    {
        $sql = 'SELECT psh.id, psh.agent, (SELECT COUNT(itm.id) FROM item AS itm WHERE itm.feed_id IN ( SELECT subscribe.feed_id FROM action_feed_member AS subscribe WHERE subscribe.member_id = psh.member_id AND subscribe.action_id = 3) AND itm.id NOT IN (SELECT unread.item_id FROM action_item_member AS unread WHERE unread.member_id = psh.member_id AND unread.action_id = 1) ) AS unread FROM push AS psh';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        foreach($results as $result) {
            if($result['unread'] > 0) {
                $payload = json_encode(array(
                    'title' => $result['unread'].' unread items',
                    'body' => '',
                ));
                $this->send($result['id'], $payload);
            }
        }
    }

    public function send($push_id, $payload)
    {
        $push = $this->getOne(['id' => $push_id]);

        $apiKeys = array(
            'GCM' => $this->gcm,
        );

        $webPush = new WebPush($apiKeys);

        $endPoint = $push->getEndpoint();
        $userPublicKey = $push->getPublicKey();
        $userAuthToken = $push->getAuthenticationSecret();

        $webPush->sendNotification($endPoint, $payload, $userPublicKey, $userAuthToken, true);

        $webPush->flush();
    }
}
