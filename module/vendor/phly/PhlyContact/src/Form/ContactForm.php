<?php

namespace PhlyContact\Form;

use Laminas\Captcha\AdapterInterface as CaptchaAdapter;
use Laminas\Form\Element;
use Laminas\Form\Form;

class ContactForm extends Form
{
    protected $captchaAdapter;
    protected $csrfToken;

    public function __construct($name = null, CaptchaAdapter $captchaAdapter = null)
    {
        parent::__construct($name);

        if (null !== $captchaAdapter) {
            $this->captchaAdapter = $captchaAdapter;
        }

        $this->init();
    }

    public function init()
    {
        $name = $this->getName();
        if (null === $name) {
            $this->setName('contact');
        }

        $this->add([
            'name' => 'email',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Email:',
                'label_attributes' => [
                    'class' => 'form-label',
                ]
            ],
            'attributes' => [
                'type' => 'email',
                'id' => 'email',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'subject',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Subject:',
                'label_attributes' => [
                    'class' => 'form-label',
                ],
            ],
            'attributes' => [
                'type' => 'subject',
                'id' => 'subject',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);


        $this->add([
            'name' => 'body',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Your message:',
                'label_attributes' => [
                    'class' => 'form-label',
                ],
            ],
            'attributes' => [
                'type' => 'textarea',
                'id' => 'body',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $captcha = new Element\Captcha('captcha');
        $captcha->setCaptcha($this->captchaAdapter);
        $captcha->setOptions([
            'label' => 'Please verify you are human.',
            'label_attributes' => [
                'class' => 'form-label',
            ],
        ]);
        $captcha->setAttributes([
            'type' => 'text',
            'id' => 'captcha',
            'class' => 'form-control',
            'required' => 'required',
        ]);
        $this->add($captcha);

        $this->add(new Element\Csrf('csrf'));

        $this->add([
            'name' => 'Send',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Send',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}
