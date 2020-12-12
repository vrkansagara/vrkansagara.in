<?php

namespace Application\Form;

use Laminas\Form\Form;

class SearchForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->init();
    }

    public function init()
    {
        $name = $this->getName();
        if (null === $name) {
            $this->setName('search');
        }

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'searchAnyThing',
            'type' => 's',
            'options' => [
                'placeholder' => 'Search anything...'
            ],
        ]);
    }
}
