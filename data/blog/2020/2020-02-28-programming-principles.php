<?php

use PhlyBlog\AuthorEntity;
use PhlyBlog\EntryEntity;

$entry  = new EntryEntity();
$author = new AuthorEntity();
$author->fromArray([
    'id'    => 'vrkansagara',
    'name'  => 'Vallabh Kansagara',
    'email' => 'vrkansagara@gmail.com',
    'url'   => 'https://vrkansagara.in',
]);

$entry->setId(pathinfo(__FILE__, PATHINFO_FILENAME));
$entry->setTitle(str_replace('-', ' ', ucfirst(substr($entry->getId(), 11))));
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2020:02:28 23:59:00'));
$entry->setUpdated(new DateTime('2020:02:28 23:59:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['principles', 'php']);

$body = <<<'EOT'
While I have started my journey to the `Programming world`, I come accross many principles which I am list down here 
for easy understanding.
EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
![KISS](/assets/images/blog/unnamed.png)

![DRY!](/assets/images/blog/dry-css-a-dontrepeatyourself-methodology-for-creating-efficient-unified-and-scalable-stylesheets-10-728.jpg)

![SOLID](/assets/images/blog/SOLID.jpg)

![SOLID](/assets/images/blog/1_YwvHjyM-BLFizN_TkTvrLw.png)
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
