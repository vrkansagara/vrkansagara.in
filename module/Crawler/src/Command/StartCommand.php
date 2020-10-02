<?php
namespace  Crawler\Command;

use Symfony\Component\Console\Command\Command;

class StartCommand extends Command
{

    public function indexAction()
    {
        var_dump(__FILE__,__LINE__); exit;
    }
}