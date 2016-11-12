<?php

namespace AppBundle\Repository;

/**
 * Repository for Platform entity
 *
 * @package AppBundle\Repository
 * @author  Lukasz Lewandowski <luklewluk@gmail.com>
 */
class PlatformRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get number of total platforms
     *
     * @return int
     */
    public function totalItems()
    {
        $qb = $this->createQueryBuilder('total_items')
            ->select('count(platform.id)')
            ->from('AppBundle:platform', 'platform')
        ;

        return (int)$qb->getQuery()->getSingleScalarResult();
    }
}
