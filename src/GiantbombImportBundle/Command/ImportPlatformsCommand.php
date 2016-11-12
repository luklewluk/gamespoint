<?php

namespace GiantbombImportBundle\Command;

use AppBundle\Repository\PlatformRepository;
use DBorsatto\GiantBomb;
use GiantbombImportBundle\Processor\PlatformProcessor;
use GiantbombImportBundle\Provider\PlatformProvider;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commands for GiantBomb platform import
 *
 * @package GiantbombImportBundle\Command
 * @author  Lukasz Lewandowski <luklewluk@gmail.com>
 */
class ImportPlatformsCommand extends ContainerAwareCommand
{
    /**
     * Commands configuration
     */
    protected function configure()
    {
        $this
            ->setName('giantbomb:platforms:import')
            ->setDescription('Imports all platforms for games.')
        ;
    }

    /**
     * Execute the current command
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var PlatformProvider $provider */
        $provider = $this->getContainer()->get('giantbomb_import_bundle.platform.provider');
        /** @var PlatformProcessor $processor */
        $processor = $this->getContainer()->get('giantbomb_import_bundle.platform.processor');
        /** @var PlatformRepository $platformRepository */
        $platformRepository = $this->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('AppBundle:Platform')
        ;

        $existingPlatforms = $platformRepository->totalItems();

        if ($existingPlatforms > 0) {
            $platformList = $provider->getNewPlatformList($existingPlatforms);
        } else {
            $platformList = $provider->getFullPlatformList();
        }

        $processor->process($platformList);

        $output->writeln(sprintf('Processed %s platforms', count($platformList)));
    }
}
