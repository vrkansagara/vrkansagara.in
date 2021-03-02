<?php

declare(strict_types=1);

namespace Album;

use Blog\Delegators\PhlyCompilerDelegatorFactory;
use Blog\Factory\PhlyBlogViewFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

$test = [];
return [
    'service_manager' => [
        'factories' => [
            'PhlyBlog\Console\View' => PhlyBlogViewFactory::class,
//            'PhlyBlog\Console\CompileCommand' => CompileCommandFactory::class,

        ],
        'delegators' => [
            'PhlyBlog\Compiler' => [PhlyCompilerDelegatorFactory::class],
        ],
    ],
    'disqus' => [
        'key' => 'vrkansagara',
        'development' => 0,
    ],
    'blog' => [
        'options' => [
            // The following indicate where to write files. Note that this
            // configuration writes to the "public/" directory, which would
            // create a blog made from static files. For the various
            // paginated views, "%d" is the current page number; "%s" is
            // typically a date string (see below for more information) or tag.

            'by_day_filename_template' => 'public/blog/day/%s-p%d.html',
            'by_month_filename_template' => 'public/blog/month/%s-p%d.html',
            'by_tag_filename_template' => 'public/blog/tag/%s-p%d.html',
            'by_year_filename_template' => 'public/blog/year/%s-p%d.html',
            'entries_filename_template' => 'public/blog/index-p%d.html',

            // In this case, the "%s" is the entry ID.
            'entry_filename_template' => 'public/blog/%s.html',

            // For feeds, the final "%s" is the feed type -- "atom" or "rss". In
            // the case of the tag feed, the initial "%s" is the current tag.
            'feed_filename' => 'public/blog/index-%s.xml',
            'tag_feed_filename_template' => 'public/blog/tag/%s-%s.xml',

            // This is the link to a blog post
            'entry_link_template' => '/blog/%s.html',

            // These are the various URL templates for "paginated" views. The
            // "%d" in each is the current page number.
            'entries_url_template' => '/blog/index-p%d.html',
            // For the year/month/day paginated views, "%s" is a string
            // representing the date. By default, this will be "YYYY",
            // "YYYY/MM", and "YYYY/MM/DD", respectively.
            'by_year_url_template' => '/blog/year/%s-p%d.html',
            'by_month_url_template' => '/blog/month/%s-p%d.html',
            'by_day_url_template' => '/blog/day/%s-p%d.html',

            // These are the primary templates you will use -- the first is for
            // paginated lists of entries, the second for individual entries.
            // There are of course more templates, but these are the only ones
            // that will be directly referenced and rendered by the compiler.
            'entries_template' => 'blog/list',
            'entry_template' => 'blog/entry',

            // The feed author information is default information to use when
            // the author of a post is unknown, or is not an AuthorEntity
            // object (and hence does not contain this information).
            'feed_author_email' => 'vrkansagara@gmail.com',
            'feed_author_name' => 'Vallabh Kansagara (VRKANSAGARA)',
            'feed_author_uri' => 'https://vrkansagara.in/',
            'feed_hostname' => 'https://vrkansagara.in',
            'feed_title' => 'Blog Entries - Vallabh Kansagara(VRKANSAGARA) Blog',
            'tag_feed_title_template' => 'Tag: %s - Vallabh Kansagara(VRKANSAGARA) Blog',


            'author_feed_filename_template' => 'public/blog/author/%s-%s.xml',
            'author_feed_title_template' => 'Author: %s - Vallabh Kansagara(VRKANSAGARA) Blog',
            'by_author_filename_template' => 'public/blog/author/%s-p%d.html',

            // If generating a tag cloud, you can specify options for
            // Laminas\Tag\Cloud. The following sets up percentage sizing from
            // 80-300%
            'tag_cloud_options' => [
                'tagDecorator' => [
                    'decorator' => 'html_tag',
                    'options' => [
                        'fontSizeUnit' => '%',
                        'minFontSize' => 80,
                        'maxFontSize' => 300,
                    ],
                ]
            ],
        ],
        // This is the location where you are keeping your post files (the PHP
        // files returning `PhlyBlog\EntryEntity` objects).
        'posts_path' => 'data/blog/',

        // Tag cloud generation is possible, but you likely need to capture
        // the rendered cloud to inject elsewhere. You can do this with a
        // callback.
        // The callback will receive a Laminas\Tag\Cloud instance, the View
        // instance, application configuration // (as an array), and the
        // application's Locator instance.
        'cloud_callback' => ['Blog\Module', 'handleTagCloud'],
    ],
    'router' => [
        'routes' => [
            'blog' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/blog/',
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'index' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/index.html',
                        ],
                    ],
                    'feed-atom' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/index-atom.xml',
                        ],
                    ],
                    'feed-rss' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/index-rss.xml',
                        ],
                    ],
                    'tag' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/tag[/:name].html',
                            'constraints' => [
                                'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ]
                        ],
                    ],
                ],
            ]
        ],
    ],
];
