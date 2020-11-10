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
$entry->setCreated(new DateTime('2019:12:08 16:33:48'));
$entry->setUpdated(new DateTime('2019:12:08 16:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['laravel', 'php']);

$body = <<<'EOT'
## For Nested Set pattern , I would suggest to follow this links

## The theory behind, a TL;DR version

An easy way to visualize how a nested set works is to think of a parent entity surrounding all of its children,
 and its parent surrounding it, etc. So this tree:
EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'

    root
      |_ Child 1
        |_ Child 1.1
        |_ Child 1.2
      |_ Child 2
        |_ Child 2.1
        |_ Child 2.2

Could be visualized like this:

     ___________________________________________________________________
    |  Root                                                             |
    |    ____________________________    ____________________________   |
    |   |  Child 1                  |   |  Child 2                  |   |
    |   |   __________   _________  |   |   __________   _________  |   |
    |   |  |  C 1.1  |  |  C 1.2 |  |   |  |  C 2.1  |  |  C 2.2 |  |   |
    1   2  3_________4  5________6  7   8  9_________10 11_______12 13  14
    |   |___________________________|   |___________________________|   |
    |___________________________________________________________________|

The numbers represent the left and right boundaries. The table then might look like this:

    id | parent_id | lft  | rgt  | depth | data
     1 |           |    1 |   14 |     0 | root
     2 |         1 |    2 |    7 |     1 | Child 1
     3 |         2 |    3 |    4 |     2 | Child 1.1
     4 |         2 |    5 |    6 |     2 | Child 1.2
     5 |         1 |    8 |   13 |     1 | Child 2
     6 |         8 |    9 |   10 |     2 | Child 2.1
     7 |         8 |   11 |   12 |     2 | Child 2.2

  For more information you can follow links.

*   [https://github.com/etrepat/baum](https://github.com/etrepat/baum)
*   [https://github.com/rails/acts_as_nested_set/blob/master/lib/active_record/acts/nested_set.rb]
(https://github.com/rails/acts_as_nested_set/blob/master/lib/active_record/acts/nested_set.rb)
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
