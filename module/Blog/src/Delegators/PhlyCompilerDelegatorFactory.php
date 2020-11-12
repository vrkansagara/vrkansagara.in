<?php

declare(strict_types=1);

namespace Blog\Delegators;

use Application\Model\SearchTable;
use Carbon\Carbon;
use Carbon\Cli\Invoker;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\RendererInterface;
use PhlyBlog\Compiler\Event;
use PhlyBlog\EntryEntity;

class PhlyCompilerDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $factory, array $options = null)
    {

        $compiler = $factory();
        $eventManager = $compiler->getEventManager();
        $searchModel = $container->get(SearchTable::class);
        $type = 'blog';
        $searchModel->cleanSearchData($type);

        $filePath = sprintf('%s/%s',getcwd(),'module/Application/view/blog/home-post.phtml');
        file_put_contents($filePath,null);
        $eventManager->attach('compile', function (Event $event) use ($searchModel, $type,$container,$filePath) {

            /** @var $entry EntryEntity */
            $entry = $event->getEntry();

            // Logic for last updated post list, for home page @START
            $lastUpdatedBlogEntries = Carbon::now()->subDays(3);
            $blogPostUpdatedDate = Carbon::parse($entry->getUpdated());
            if ($blogPostUpdatedDate->isAfter($lastUpdatedBlogEntries) && $entry->isPublic()){
                /** @var RendererInterface $renderer */
                $renderer = $container->get(RendererInterface::class);

                // $entry
                $view = new ViewModel();
                $view->setTemplate('blog/entry-short-post');
                $view->setVariables(['entry' => $entry]);
                $html = $renderer->render($view);
                file_put_contents($filePath,$html,FILE_APPEND);
            }
            // Logic for last updated post list, for home page @END

            // Write logic to add search details into database. @START
            $content = $entry->getBody() . $entry->getExtended();
            $tags = $entry->getTags();
            $url = $entry->getId();
            $title = $entry->getTitle();
            /** @var  $searchModel SearchTable */
            $searchModel->insertSearchData($title, $content, $tags, $url, $type);
            // Write logic to add search details into database. @END
        });
        return $compiler;
    }
}
