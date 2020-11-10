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
$entry->setCreated(new DateTime('2020:03:11 23:59:00'));
$entry->setUpdated(new DateTime('2020:03:11 23:59:00'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['symfony', 'php']);

$body = <<<'EOT'
This is how I use to debug any twig template and it's variables.
Just include into  your twig template and pass variable = object | array | null

~~~twig
{% partial 'debug' variable=post %}
~~~

EOT;
$entry->setBody(convertMarkdownToHtml($body));

$extended = <<<'EOT'
~~~bash
{% if this.environment != ('production' or 'prod' ) %}
    <ol>
        {% if variable is defined %}
            {% set debugItem = variable %}
        {% else %}
            {% set debugItem = _context %}
        {% endif %}

        {% if debugItem is iterable %}
            {% for key, values in debugItem  %}
            <li><b>{ { key } }</b></li>
            <ol>
                {% if values is iterable %}
                {% for k, v in values  %}
                <li>{ { k } }</li>
                {% endfor %}
                {% else %}
                {# values is probably a string or json #}
                <pre class=" language-json">
                    <code class=" language-bash">
                           { { values|json_encode(constant('JSON_PRETTY_PRINT')) } }
                        </code>
                </pre>
                {% endif %}
            </ol>
            {% endfor %}
        {% else %}
        <pre class=" language-json">
                    <code class=" language-bash">
                           { { debugItem|json_encode(constant('JSON_PRETTY_PRINT')) } }
                        </code>
                </pre>
        {% endif %}
    </ol>
{% endif %}
~~~
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
