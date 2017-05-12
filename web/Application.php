<?php
namespace PhpDevil\web;

use PhpDevil\components\router\RouterInterface;
use PhpDevil\components\router\WebRouter;
use PhpDevil\web\http\RequestHandler;
use PhpDevil\web\http\RequestHandlerInterface;

/**
 * Class Application
 * @package PhpDevil\web
 *
 * @property RouterInterface $router
 */
class Application extends \PhpDevil\base\Application
{
    /**
     * Классы по умолчанию для компонентов с зарезервированными именами
     * @var array
     */
    protected $_defaultComponentClasses = [
        'router' => WebRouter::class,
    ];

    /**
     * Сценарий выполнения веб-приложения
     * @param RequestHandlerInterface|null $request
     */
    public function run(RequestHandlerInterface $request = null)
    {
        \Devil::registerApplication($this);
        if (null === $request) $request = new RequestHandler;
        $this->router->handleRequest($request);

    }
}