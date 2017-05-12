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
     * Передача управления действию контроллера напрямую
     * @param array $request
     */
    public function performDirectRequest(array $request)
    {
        $requestDepth = count($request);
        $module = $controller = $action = null;
        switch ($requestDepth) {
            case 3: list($module, $controller, $action) = $request;  break;
            case 2: list($controller, $action) = $request;  break;
            case 1: $action = $request[0];  break;
        }
        if ($module) $module = $this->loadModule($module);
        else $module = $this;
        if (null == $controller) $controller = 'default';
        if ($controller = $module->loadController($controller)) {
            if (null === $action) $action = 'default';
            return $controller->performAction($action);
        }
    }

    /**
     * Сценарий выполнения веб-приложения
     * @param RequestHandlerInterface|null $request
     */
    public function run(RequestHandlerInterface $request = null)
    {
        \Devil::registerApplication($this);
        if (null === $request) $request = new RequestHandler;
        $this->router->handleRequest($request);
        if ($direct = $this->router->getDirectRequest('before')) {
            $this->performDirectRequest($direct);
        }
    }
}