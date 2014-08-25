<?php

namespace Symfony\Toolbelt\Installer;

use ZipArchive;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/*
 * This class is heavily inspired by Laravel Installer and
 * uses some parts of its code.
 * (c) Taylor Otwell: https://github.com/laravel/installer
 */
class NewCommand extends Command
{
    private $fs;

    protected function configure()
    {
        $this
            ->setName('new')
            ->setDescription('Creates a new Symfony project.')
            ->addArgument('name', InputArgument::REQUIRED)
            // TODO: allow to select the Symfony version
            // ->addArgument('version', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fs = new Filesystem();

        if (is_dir($dir = getcwd().DIRECTORY_SEPARATOR.$input->getArgument('name'))) {
            throw new \RuntimeException(sprintf("Project directory already exists:\n%s", $dir));
        }

        $this->fs->mkdir($dir);

        // TODO: verify the format of the Symfony version

        $output->writeln("\n Downloading Symfony...");

        $zipFilePath = $dir.DIRECTORY_SEPARATOR.'.symfony_'.uniqid(time()).'.zip';

        $this->download($zipFilePath)
             ->extract($zipFilePath, $dir)
             ->cleanUp($zipFilePath);

        $output->writeln(<<<MESSAGE

 <info>✔</info>  Symfony was <info>successfully installed</info>. Now you can:

    * Configure your application in <comment>app/config/parameters.yml</comment> file.

    * Run your application:
        1. Execute the <comment>php app/console server:run</comment> command.
        2. Browse to the <comment>http://localhost:8000</comment> URL.

    * Read the documentation at symfony.com/doc
MESSAGE
);
    }

    protected function download($targetPath)
    {
        // TODO: show a progressbar when downloading the file
        $response = \GuzzleHttp\get('http://symfony.com/download?v=Symfony_Standard_Vendors_2.5.3.zip');
        $this->fs->dumpFile($targetPath, $response->getBody());

        return $this;
    }

    protected function extract($zipFilePath, $projectDir)
    {
        $archive = new ZipArchive;

        $archive->open($zipFilePath);
        $archive->extractTo($projectDir);
        $archive->close();

        $this->fs->mirror($projectDir.DIRECTORY_SEPARATOR.'Symfony', $projectDir);

        return $this;
    }

    protected function cleanUp($zipFile)
    {
        $this->fs->remove($zipFile);

        return $this;
    }
}
