<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Application\Model\SearchTable;
use Application\Module;
use GuzzleHttp\Client;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\Uri;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    private $config;

    private $searchTable;

    public function __construct(
        $applicationConfig,
        SearchTable $searchTable
    ) {
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
        } elseif (filter_var($searchInfo, FILTER_VALIDATE_URL)) {
            $this->checkUrl($searchInfo);
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


    public function checkUrl(string $url)
    {
        // Create a request
        $request = (new Request())->withUri(new Uri($url));

        $client = new Client();
        $response = $client->send($request);

        $bodyContent = $response->getBody();
        $newBuffer = Module::compress($bodyContent);

        $oldBufferLength = strlen((string) $bodyContent);
        $newBufferLength = strlen($newBuffer);
        printf('Old buffer length is %d , new buffer %d, you can compress %s per request.', $oldBufferLength, $newBufferLength, Module::formatSizeUnits($oldBufferLength - $newBufferLength));
//        printf("Response status: %d (%s)\n", $response->getStatusCode(), $response->getReasonPhrase());
//        printf("Headers:\n");
//        foreach ($response->getHeaders() as $header => $values) {
//            printf("    %s: %s\n", $header, implode(', ', $values));
//        }
//        printf("Message:\n%s\n", $newBuffer);
        exit;
    }

    public function postdataAction()
    {
        try{
            $request    = $this->getRequest();
            if ($request->isPost()){
                $payLoad = $request->getPost()->getArrayCopy();
                $filePath = getcwd() . '/data/tmp.txt';
                $payLoad['timestamp'] = Carbon::now()->format('Y-m-d H:i:s');
                file_put_contents($filePath,json_encode($payLoad),FILE_APPEND);
            }
            $response = new JsonResponse([
                'message' => 'Sent successfully!',
                'data' => [],
            ]);
            return $response;
        }catch (\Exception $exception){
            throw $exception;
        }
    }
}
