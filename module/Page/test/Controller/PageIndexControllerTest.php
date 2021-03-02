<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Blog\Controller;

use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class PageIndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp(): void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();
    }

    public function testDependentModuleMustBeLoadedFirst()
    {
        $this->assertModulesLoaded(['PhlySimplePage']);
    }

    public function testContactPageIsAssible()
    {
        $this->dispatch('/page/contact', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('phlysimplepage');
        $this->assertControllerName('PhlysimplePage\PageController'); // as specified in router's controller name alias
        $this->assertControllerClass('PageController');
        $this->assertMatchedRouteName('page/contact');
    }

    public function testHomePageMustNotBeSimplePage()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Application');
        $this->assertNotControllerName('PhlysimplePage\PageController'); // as specified in router's controller name alias
        $this->assertNotControllerClass('PageController');
        $this->assertNotMatchedRouteName('page/home');
    }
}
