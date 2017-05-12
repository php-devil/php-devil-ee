<?php
namespace PhpDevil\abstractions;
use PhpDevil\exceptions\UnknownTagException;

class AbstractApplication extends AbstractModule
{
    /**
     * Подключенные к приложению модули
     * @var array
     */
    protected $_knownModules = [];

    /**
     * Загрузка модуля по псевдониму
     * @param $tagName
     * @return null
     * @throws UnknownTagException
     */
    public function loadModule($tagName)
    {
        if (isset($this->_knownModules[$tagName])) {
            $className = $this->_knownModules[$tagName]['class'];
            $module =  new $className($this->_knownModules[$tagName]['config']);
            $module->setOwner($this);
            return $module;
        } else {
            throw new UnknownTagException(['module', $tagName, $this]);
        }
    }

    /**
     * Передача управления действию контроллера напрямую
     * @param array $request
     * @return mixed
     */
    public function performDirectRequest(array $request)
    {
        if (3 === count($request)) {
            $moduleName = array_shift($request);
            if ($module = $this->loadModule($moduleName)) {
                return $module->performDirectRequest($request);
            }
        } else {
            return parent::performDirectRequest($request);
        }
    }

    public function registerModule($tag, $config)
    {
        $className = null;
        $conf = null;
        if (is_string($config)) $className = $config;
        else {
            if (isset($config['class'])) $className = $config['class'];
            unset($config['class']);
            if (!empty($config)) $conf = $config;
        }
        if (class_exists($className)) {
            $this->_knownModules[$tag] = [
                'class' => $className,
                'config' => $conf
            ];
        } else {

        }
    }

    /**
     * Конфигурационный массив модулей
     * @return array
     */
    public static function modules()
    {
        $modules = [];
        if (($config = static::getConfig()) && isset($config['data']['modules'])) {
            $modules = $config['data']['modules'];
        }
        return $modules;
    }

    public function __construct()
    {
        parent::__construct();
        if (!empty($modules = static::modules())) foreach ($modules as $tag=>$config) {
            $this->registerModule($tag, $config);
        }
    }

    public function __destruct()
    {
        $this->end();
    }

    public function end()
    {
        \Devil::closeApplication($this);
    }
}