<?php
namespace  Crawler\Command;

use Symfony\Component\Console\Command\Command;

class InfoCommand extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        // ...
    }

//    protected function execute(InputInterface $input, OutputInterface $output)
    protected function execute()
    {
        // ... put here the code to run in your command

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }
}