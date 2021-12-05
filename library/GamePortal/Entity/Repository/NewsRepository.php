<?php

namespace GamePortal\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * 
 */
class NewsRepository extends EntityRepository
{
    /**
     * 
     * @param integer $limit
     * @return array 
     */
    public function getLatestNews($limit = NULL) {        
        
        $query = $this->getEntityManager()->createQueryBuilder();
        
        $query->select('n','p.title')->from('GamePortal\Entity\News', 'n')
              ->join('n.platforms', 'p')
              ->orderBy('n.date', 'DESC');
        
        if(!empty($limit)){$query->setMaxResults($limit);}
        
        //debug
        //\Zend_Registry::get('logger')->log($query->getQuery()->getSQL(),\Zend_Log::INFO);
        
        return $query->getQuery()->getArrayResult();        
    }
}