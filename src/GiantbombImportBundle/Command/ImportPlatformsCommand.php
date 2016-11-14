<?php

namespace GiantbombImportBundle\Command;

use AppBundle\Repository\PlatformRepository;
use DBorsatto\GiantBomb;
use GiantbombImportBundle\Processor\PlatformProcessor;
use GiantbombImportBundle\Provider\PlatformProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commands for GiantBomb platform import
 *
 * @package GiantbombImportBundle\Command
 * @author  Lukasz Lewandowski <luklewluk@gmail.com>
 */
class ImportPlatformsCommand extends Command
{
    /** @var PlatformProvider Platform API provider */
    protected $provider;

    /** @var PlatformProcessor Platform Processor */
    protected $processor;

    /** @var PlatformRepository Platform Repository */
    protected $repository;

    /**
     * Constructor
     *
     * @param PlatformProvider   $provider   Platform Provider
     * @param PlatformProcessor  $processor  Platform Processor
     * @param PlatformRepository $repository Platform Repository
     */
    public function __construct(
        PlatformProvider $provider,
        PlatformProcessor $processor,
        PlatformRepository $repository
    ) {
        parent::__construct();

        $this->provider = $provider;
        $this->processor = $processor;
        $this->repository = $repository;
    }

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
        $existingPlatforms = $this->repository->totalItems();

        if ($existingPlatforms > 0) {
            $platformList = $this->provider->getNewPlatformList($existingPlatforms);
        } else {
            $platformList = $this->provider->getFullPlatformList();
        }

        $this->processor->process($platformList);

        $output->writeln(sprintf('Processed %s platforms', count($platformList)));
    }
}
