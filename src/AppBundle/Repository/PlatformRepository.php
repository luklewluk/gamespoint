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
        return count($this->findAll());
    }
}
