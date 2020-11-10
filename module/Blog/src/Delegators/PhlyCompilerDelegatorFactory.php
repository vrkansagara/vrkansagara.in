<?php

declare(strict_types=1);

namespace Blog\Delegators;

use Application\Model\SearchTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
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
        $eventManager->attach('compile', function (Event $event) use ($searchModel, $type) {

            /** @var $entry EntryEntity */
            $entry = $event->getEntry();
            $date = $event->getDate();

            // Writie logic to add search details into database.

            $content = $entry->getBody() . $entry->getExtended();
            $tags = $entry->getTags();
            $url = $entry->getId();

            /** @var  $searchModel SearchTable */
            $searchModel->insertSearchData($content, $tags, $url, $type);

            // Filename must be same as url
            // Id and title must be same for URL
            $id = strtolower($entry->getId());
            $title = strtolower($entry->getTitle());
// Insert into database, so user can search....


//            $tmp = str_replace('-', ' ', substr($id, strlen($date)));
//            if ($tmp != $title) {
//                sprintf('%s is not matching, Please correct it.', $id);
//                exit;
//            }
        });
        return $compiler;
    }
}
