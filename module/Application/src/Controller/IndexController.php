<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Sendmail;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {

// Setup SMTP transport
        $transport = new SmtpTransport();
        $options   = new SmtpOptions([
            'name'              => 'smtp.sendgrid.net', //'smtp.mailtrap.io',
            'host'              => 'smtp.sendgrid.net', //'smtp.mailtrap.io',
            'port'              => 587,
        'connection_class'  => 'login',
        'connection_config' => [
        'username' => 'apikey', //'d934fa534ee329',
        'password' => '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', //'8456f4c9177b0b',
            ],
        ]);
        $transport->setOptions($options);


        $mail = new Message();
        $mail->setBody('This is the text of the email......');
        $mail->setFrom('vallabh@vrkansagara.in', 'VRKANSAGARA');
        $mail->addTo('vrkansagara@gmail.com', 'Vallabh Kansagara');
        $mail->setSubject('TestSubject');

//        $transport = new Sendmail('-freturn_to_me@example.com');
//        $transport->send($mail);

        $transport->send($mail);

        return new ViewModel();
    }

    public function searchAction()
    {
        return new ViewModel();
    }
}
