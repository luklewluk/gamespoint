<?php

namespace GiantbombImportBundle\Processor;

use AppBundle\Entity\Platform;
use DBorsatto\GiantBomb;
use Doctrine\ORM\EntityManager;

/**
 * GiantBomb import platforms processor
 *
 * @package GiantbombImportBundle\Processor
 * @author  Lukasz Lewandowski <luklewluk@gmail.com>
 */
class PlatformProcessor
{
    /** @var EntityManager */
    protected $manager;

    /**
     * Constructor
     *
     * @param EntityManager $repository Doctrine Entity Manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Process GiantBomb platform models and save in the database
     *
     * @param GiantBomb\Model[] $platformList GiantBomb platform models
     *
     * @return void
     */
    public function process(array $platformList)
    {
        foreach ($platformList as $platform) {
            if (!$platform->has('name')) {
                continue;
            }

            $entity = new Platform();
            $entity->setName($platform->get('name'));
            $this->manager->persist($entity);
        }

        $this->manager->flush();
    }
}
