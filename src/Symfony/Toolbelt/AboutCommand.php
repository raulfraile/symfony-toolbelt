<?php

namespace Symfony\Toolbelt;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AboutCommand extends Command
{
    private $appVersion;

    public function __construct($appVersion)
    {
        parent::__construct();

        $this->appVersion = $appVersion;
    }

    protected function configure()
    {
        $this
            ->setName('about')
            ->setDescription('Symfony Toolbelt Help.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("\n <info>Symfony Toolbelt</info> <comment>%s</comment>", $this->appVersion));
        $output->writeln(" ~~~~~~~~~~~~~~~~~~~~");

        $output->writeln(" This project provides several utilities for managing Symfony.\n");

        $output->writeln(" Available commands:");

        $output->writeln("   <info>new <dir-name></info>  Creates a new Symfony project in the given directory.");
        $output->writeln("                   Example: <comment>$ symfony new blog/</comment>\n");
    }
}
