<?php

namespace GiantbombImportBundle\Provider;

use DBorsatto\GiantBomb;

/**
 * GiantBomb Platform Provider
 *
 * @package GiantbombImportBundle\Provider
 * @author  Lukasz Lewandowski <luklewluk@gmail.com>
 */
class PlatformProvider
{
    /** @var GiantBomb\Client The GiantBomb client */
    protected $client;

    /**
     * Constructor
     *
     * @param GiantBomb\Client $client The GiantBomb client
     */
    public function __construct(GiantBomb\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get all platforms from GiantBomb
     *
     * @return GiantBomb\Model[]
     */
    public function getFullPlatformList()
    {
        $platformList = [];

        $i = 0;
        do {
            $platforms = $this->getPlatformList($i * 100);
            $platformList = array_merge($platformList, $platforms);
            $i++;
        } while (count($platforms) === 100);

        return $platformList;
    }

    /**
     * Get only new platforms from GiantBomb based on number of items in the local DB
     *
     * @param int $offset Number of existing platforms
     *
     * @return GiantBomb\Model[]
     */
    public function getNewPlatformList($offset)
    {
        $platformList = [];

        $i = 0;
        do {
            $platforms = $this->getPlatformList(($i * 100) + $offset);
            $platformList = array_merge($platformList, $platforms);
            $i++;
        } while (count($platforms) === 100);

        return $platformList;
    }

    /**
     * Get platform list from GiantBomb
     *
     * @param int $offset Offset
     * @param int $limit  Limit - API maximum value is 100
     *
     * @return GiantBomb\Model[]
     */
    public function getPlatformList($offset = 0, $limit = 0)
    {
        $platforms = $this->client->getRepository('Platform')->query()
            ->setFieldList(['id', 'name'])
            ->setParameter('limit', $limit)
            ->setParameter('offset', $offset)
            ->find()
        ;

        return $platforms;
    }
}
