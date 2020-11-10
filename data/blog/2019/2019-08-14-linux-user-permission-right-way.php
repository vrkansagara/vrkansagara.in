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
$entry->setCreated(new DateTime('2019:08:14 19:33:48'));
$entry->setUpdated(new DateTime('2019:08:14 19:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['linux','server','nginx']);

$body = <<<'EOT'
> ![](/assets/images/blog/Files-permissions-and-ownership-basics-in-Linux.png)
## To solve linux user and group permission issue for any kind of project.

First  of all find the right user and right group which is executing that process.


## Silver bullet of linux user permission.

~~~bash
sudo lsof -iTCP -sTCP:LISTEN -Pn
export OWENRE=$(whoami)
export GROUP=$(whoami)
~~~
EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'


Use above command to grap `process` and find whois the right owner of that process and export variable as `OWENRE` and `GROUP`

~~~bash
sudo chgrp $GROUP * -Rf
sudo chown $OWENRE * -Rf
sudo find ./ -type f -exec chmod 664 {} \;    
sudo find ./ -type d -exec chmod 775 {} \;
~~~

### Laravel specific issue.
~~~bash
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
~~~

> Rre-read image for more understanding.

> Don't use `0777` or `777` for `chmod`
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
