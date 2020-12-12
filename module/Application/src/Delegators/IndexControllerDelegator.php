<?php

declare(strict_types=1);

namespace Application\Delegators;

use Application\Controller\IndexController;
use Laminas\EventManager\EventManagerInterface;

class IndexControllerDelegator extends IndexController
{
    protected $indexController;
    protected $eventManager;

    public function __construct(IndexController $indexController, EventManagerInterface $eventManager)
    {
        $this->indexController = $indexController;
        $this->eventManager    = $eventManager;
    }

    public function indexAction()
    {
        $this->eventManager->trigger('indexActionEvent', $this);
        return $this->indexController->indexAction();
    }
}
