<?php

namespace GiantbombImportBundle\Command;

use DBorsatto\GiantBomb\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportPlatformsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('giantbomb:platforms:import')
            ->setDescription('Imports all platforms for games.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Todo: implement import
    }

    protected function getPlatformList($offset = 0, $limit = 0)
    {
        /** @var Client $client */
        $client = $this->getContainer()->get('giantbomb.client');
        $platforms = $client->getRepository('Platform')->query()
            ->setFieldList(['id', 'name'])
            ->setParameter('limit', $limit)
            ->setParameter('offset', $offset)
            ->find();

        return $platforms;
    }

}
