<?php
namespace PhpDevil\abstractions;

class AbstractApplication extends AbstractModule
{
    /**
     * Подключенные к приложению модули
     * @var array
     */
    protected $_knownModules = [];

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