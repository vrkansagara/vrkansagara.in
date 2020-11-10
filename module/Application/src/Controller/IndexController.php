<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Application\Model\SearchTable;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    private $config;

    private $searchTable;

    public function __construct(
        $applicationConfig,
        SearchTable $searchTable
    )
    {
        $this->config = $applicationConfig;
        $this->searchTable = $searchTable;
    }

    /**
     * We override the parent class' onDispatch() method to
     * set an alternative layout for all actions in this controller.
     */
//    public function onDispatch(MvcEvent $e)
//    {
//        // Call the base class' onDispatch() first and grab the response
//        $response = parent::onDispatch($e);
//
//        // Set alternative layout
//        $this->layout()->setTemplate('layout/layout');
//
//        // Return the response
//        return $response;
//    }

    public function indexAction()
    {
        // Check if site user is allowed to visit the "index" page
//        $isAllowed = $this->access()->checkAccess(__METHOD__);
//        $isAllowed = $this->plugin(AccessPlugin::class)->checkAccess(__METHOD__);

        $inspire = [
            [
                'text' => "Don't repeat yourself",
                'author' => null
            ]
        ];
        $count = count($inspire) - 1;

        return new ViewModel([
            'inspire' => $inspire[rand(0, $count)],
        ]);
    }

    /**
     * @return ViewModel
     */
    public function searchAction()
    {
        $searchInfo = $this->getRequest()->getQuery('name');


        /** @var $searchData ResultSet */
        $searchData = $this->searchTable->search($searchInfo);


        if (filter_var($searchInfo, FILTER_VALIDATE_IP)) {
            $info = getMyInfo($searchInfo);
        } elseif ($searchInfo == 'tag:php') {
            return $this->redirect()->toRoute('blog/tag', ['name' => 'php']);
        } else {
            $info = [];
        }
        return new ViewModel(
            [
                'info' => $info,
                'search' => $searchData
            ]
        );
    }
}
