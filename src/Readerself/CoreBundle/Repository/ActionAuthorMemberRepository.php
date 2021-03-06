<?php
namespace Readerself\CoreBundle\Repository;

use Readerself\CoreBundle\Repository\AbstractRepository;

class ActionAuthorMemberRepository extends AbstractRepository
{
    public function getOne($parameters = []) {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder();
        $query->addSelect('act_cat_mbr', 'act', 'cat', 'mbr');
        $query->from('ReaderselfCoreBundle:ActionAuthorMember', 'act_cat_mbr');
        $query->leftJoin('act_cat_mbr.action', 'act');
        $query->leftJoin('act_cat_mbr.author', 'cat');
        $query->leftJoin('act_cat_mbr.member', 'mbr');

        if(isset($parameters['id']) == 1) {
            $query->andWhere('act_cat_mbr.id = :id');
            $query->setParameter(':id', $parameters['id']);
        }

        if(isset($parameters['action']) == 1) {
            $query->andWhere('act_cat_mbr.action = :action');
            $query->setParameter(':action', $parameters['action']);
        }

        if(isset($parameters['author']) == 1) {
            $query->andWhere('act_cat_mbr.author = :author');
            $query->setParameter(':author', $parameters['author']);
        }

        if(isset($parameters['member']) == 1) {
            $query->andWhere('act_cat_mbr.member = :member');
            $query->setParameter(':member', $parameters['member']);
        }

        $getQuery = $query->getQuery();
        $getQuery->setMaxResults(1);

        return $getQuery->getOneOrNullResult();
    }

    public function getList($parameters = []) {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder();
        $query->addSelect('act_cat_mbr', 'act', 'cat', 'mbr');
        $query->from('ReaderselfCoreBundle:ActionAuthorMember', 'act_cat_mbr');
        $query->leftJoin('act_cat_mbr.action', 'act');
        $query->leftJoin('act_cat_mbr.author', 'cat');
        $query->leftJoin('act_cat_mbr.member', 'mbr');

        if(isset($parameters['action']) == 1) {
            $query->andWhere('act_cat_mbr.action = :action');
            $query->setParameter(':action', $parameters['action']);
        }

        if(isset($parameters['author']) == 1) {
            $query->andWhere('act_cat_mbr.author = :author');
            $query->setParameter(':author', $parameters['author']);
        }

        if(isset($parameters['member']) == 1) {
            $query->andWhere('act_cat_mbr.member = :member');
            $query->setParameter(':member', $parameters['member']);
        }

        $query->groupBy('act_cat_mbr.id');

        $getQuery = $query->getQuery();
        return $getQuery;
    }
}
