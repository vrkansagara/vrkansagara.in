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
            'type' => 'hidden',
        ]);

        $this->add([
            'name'    => 'searchAnyThing',
            'type'    => 'text',
            'options' => [
                'placeholder' => 'Search anything...',
            ],
        ]);

        $this->add([
            'name'       => 'submit-button',
            'type'       => 'submit',
            'attributes' => [
                'value' => 'Search',
                'id'    => 'searchButton',
            ],
        ]);
        $this->setAttribute('method', 'POST');
    }
}
