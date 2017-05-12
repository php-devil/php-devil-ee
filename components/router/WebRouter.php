<?php
namespace PhpDevil\components\router;
use PhpDevil\base\Component;
use PhpDevil\web\http\RequestHandlerInterface;

class WebRouter extends Component implements RouterInterface
{
    /**
     * @var RequestHandlerInterface
     */
    private $request;

    /**
     * URL, обрабатываемые до загрузки модулей.
     * @var array
     */
    protected $_beforeModules = [];

    /**
     * URL, обрабатываемые в случае, если ни один модуль не сработал
     * @var array
     */
    protected $_afterModules = [];

    public function getDirectRequest($section)
    {
        $property = '_' . $section . 'Modules';
        $url = $this->request->getFullUri();
        if (isset($this->$property['direct'][$url])) {
            return $this->$property['direct'][$url];
        } else {
            return null;
        }
    }

    /**
     * TODO: реализовать паттерны URL адресов
     * @param $config
     */
    protected function configureBeforeModules($config)
    {
        $this->_beforeModules['direct'] = $config;
    }

    /**
     * TODO: реализовать паттерны URL адресов
     * @param $config
     */
    protected function configureAfterModules($config)
    {
        $this->_afterModules['direct'] = $config;
    }

    public function handleRequest(RequestHandlerInterface $handler)
    {
        $this->request = $handler;
    }
}