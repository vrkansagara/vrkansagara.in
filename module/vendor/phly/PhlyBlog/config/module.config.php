<?php

use Laminas\ServiceManager\Factory\InvokableFactory;
use PhlyBlog\Command\CompileCommand;
use PhlyBlog\Compiler\ResponseStrategy;
use PhlyBlog\Factory\CompileCommandFactory;
use PhlyBlog\Factory\ResponseStrategyFactory;

return array(
    'blog' => array(
        'options' => array(
            'author_feed_filename_template' => 'public/blog/author/%s-%s.xml',
            'author_feed_title_template' => 'Author: %s - ZF Blog',
            'by_author_filename_template' => 'public/blog/author/%s-p%d.html',
            'by_day_filename_template' => 'public/blog/day/%s-p%d.html',
            'by_month_filename_template' => 'public/blog/month/%s-p%d.html',
            'by_tag_filename_template' => 'public/blog/tag/%s-p%d.html',
            'by_year_filename_template' => 'public/blog/year/%s-p%d.html',
            'entries_filename_template' => 'public/blog/index-p%d.html',
            'entries_url_template' => '/blog/index-p%d.html',
            'entries_template' => 'blog/list',
            'entry_filename_template' => 'public/blog/%s.html',
            'entry_link_template' => '/blog/%s.html',
            'entry_template' => 'blog/entry',
            'feed_author_email' => 'zf-contributors@lists.zend.com',
            'feed_author_name' => 'Zend Framework Development Team',
            'feed_author_uri' => 'http://framework.zend.com/',
            'feed_filename' => 'public/blog/feed-%s.xml',
            'feed_hostname' => 'http://framework.zend.com',
            'feed_title' => 'Blog Entries - ZF Blog',
            'tag_feed_filename_template' => 'public/blog/tag/%s-%s.xml',
            'tag_feed_title_template' => 'Tag: %s - ZF Blog',
            'tag_cloud_options' => array('tagDecorator' => array(
                'decorator' => 'html_tag',
                'options' => array(
                    'fontSizeUnit' => '%',
                    'minFontSize' => 80,
                    'maxFontSize' => 300,
                ),
            )),
        ),
//        'posts_path' => __DIR__ . '/../blog',
        'posts_path' => 'data/blog',
        'view_callback' => 'Application\Module::prepareCompilerView',
        'cloud_callback' => array('Application\Module', 'handleTagCloud'),

//        'view_callback'  => 'PhlyBlog\Module::prepareCompilerView',
//        'view_callback'  => 'Application\Module::prepareCompilerView',
//        'cloud_callback' => array('Application\Module', 'handleTagCloud'),
    ),
    'view_manager' => array(
        'template_map' => array(
            'phly-blog/entry-short' => __DIR__ . '/../view/phly-blog/entry-short.phtml',
            'phly-blog/entry' => __DIR__ . '/../view/phly-blog/entry.phtml',
            'phly-blog/list' => __DIR__ . '/../view/phly-blog/list.phtml',
            'phly-blog/paginator' => __DIR__ . '/../view/phly-blog/paginator.phtml',
            'phly-blog/tags' => __DIR__ . '/../view/phly-blog/tags.phtml',


            'blog/entry-short' => __DIR__ . '/../view/phly-blog/entry-short.phtml',
            'blog/entry' => __DIR__ . '/../view/phly-blog/entry.phtml',
            'blog/list' => __DIR__ . '/../view/phly-blog/list.phtml',

        ),
        'template_path_stack' => array(
            'phly-blog' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => [
        'factories' => [
            CompileCommand::class => CompileCommandFactory::class,
        ],
    ],
    'router' => array(
        'routes' => array(
            'phly-blog' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/blog',
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'index' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/index.html',
                        ),
                    ),
                    'feed-atom' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '-atom.xml',
                        ),
                    ),
                    'feed-rss' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '-rss.xml',
                        ),
                    ),
                    'entry' => array(
                        'type' => 'Regex',
                        'options' => array(
                            'regex' => '/(?<id>[^/]+)\.html',
                            'spec' => '/%id%.html',
                        ),
                    ),
                    'author' => array(
                        'type' => 'Regex',
                        'options' => array(
                            'regex' => '/author/(?<author>[^/]+)',
                            'defaults' => array(
                                'action' => 'author',
                            ),
                            'spec' => '/author/%author%',
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'page' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '.html',
                                ),
                            ),
                            'feed-atom' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '-atom.xml',
                                ),
                            ),
                            'feed-rss' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '-rss.xml',
                                ),
                            ),
                        ),
                    ),
                    'tag' => array(
                        'type' => 'Regex',
                        'options' => array(
                            'regex' => '/tag/(?<tag>[^/.-]+)',
                            'defaults' => array(
                                'action' => 'tag',
                            ),
                            'spec' => '/tag/%tag%',
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'page' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '.html',
                                ),
                            ),
                            'feed-atom' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '-atom.xml',
                                ),
                            ),
                            'feed-rss' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '-rss.xml',
                                ),
                            ),
                        ),
                    ),
                    'year' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/year/:year.html',
                            'constraints' => array(
                                'year' => '\d{4}',
                            ),
                            'defaults' => array(
                                'action' => 'year',
                            ),
                        ),
                    ),
                    'month' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/month/:year/:month.html',
                            'constraints' => array(
                                'year' => '\d{4}',
                                'month' => '\d{2}',
                            ),
                            'defaults' => array(
                                'action' => 'month',
                            ),
                        ),
                    ),
                    'day' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/day/:year/:month/:day.html',
                            'constraints' => array(
                                'year' => '\d{4}',
                                'month' => '\d{2}',
                                'day' => '\d{2}',
                            ),
                            'defaults' => array(
                                'action' => 'day',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

//    'console' => array(
//        'router' => array(
//            'routes' => array(
//                'phly-blog-compile' => array(
//                    'type' => 'Simple',
//                    'options' => array(
//                        'route' => 'blog compile [--all|-a] [--entries|-e] [--archive|-c] [--year|-y] [--month|-m] [--day|-d] [--tag|-t] [--author|-r]',
//                        'defaults' => array(
//                            'controller' => 'PhlyBlog\CompileController',
//                            'action' => 'compile',
//                        ),
//                    ),
//                ),
//            )),
//    ),
);
