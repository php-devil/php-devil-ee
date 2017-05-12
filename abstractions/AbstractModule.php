<?php
namespace PhpDevil\abstractions;

use PhpDevil\exceptions\InvalidComponentClassException;
use PhpDevil\exceptions\UnknownComponentException;
use PhpDevil\exceptions\UnknownTagException;

class AbstractModule extends AbstractController
{
    /**
     * Компоненты заданного уровня вложения фронт-контроллера
     * @var array
     */
    protected $_knownComponents = [];

    /**
     * Классы по умолчанию для компонентов с зарезервированными именами
     * @var array
     */
    protected $_defaultComponentClasses = [];

    /**
     * Проинициализированные классы компонентов
     * @var array
     */
    protected $_components = [];

    /**
     * Контроллеры, известные фронт-контроллеру на заданном уолвне
     * @var array
     */
    protected $_knownControllers = [];

    /**
     * Известные данному фронт-контроллеру модели
     * @var array
     */
    protected $_knownModels = [];

    /**
     * Передача управления контроллеру по прямому запросу array(контроллер [, действие])
     * @param array $request
     * @return mixed
     * @throws UnknownTagException
     */
    public function performDirectRequest(array $request)
    {
        $controller = array_shift($request);
        echo $controller;
        if ($controller = $this->loadController($controller)) {
            $action = array_shift($request);
            if (empty($action)) $action = 'default';
            return $controller->performAction($action);
        }
    }

    /**
     * Для фронт-контроллеров обращение к несуществующему полю класса
     * считается вызовом одноименного компонента
     * @param $name
     * @return mixed
     * @throws UnknownComponentException
     */
    public function __get($name)
    {
        if (!isset($this->_components[$name])) {
            if (isset($this->_knownComponents[$name])) {
                $className = $this->_knownComponents[$name]['class'];
                $config    = $this->_knownComponents[$name]['config'];
                $this->_components[$name] = new $className($config);
            } else {
               throw new UnknownComponentException([$name, $this]);
            }
        }
        return $this->_components[$name];
    }

    /**
     * Загрузка контроллера по псевдониму
     * @param $tagName
     * @return null
     * @throws UnknownTagException
     */
    public function loadController($tagName)
    {
        if (isset($this->_knownControllers[$tagName])) {
            $className = $this->_knownControllers[$tagName];
            $controller =  new $className;
            $controller->setOwner($this);
            return $controller;
        } else {
            throw new UnknownTagException(['controller', $tagName, $this]);
        }
    }

    /**
     * Конфигурационный массив компонентов
     * @return array
     */
    public static function components()
    {
        $components = [];
        if (($config = static::getConfig()) && isset($config['data']['components'])) {
            $components = $config['data']['components'];
        }
        return $components;
    }

    /**
     * Конфигурационный массив контроллеров
     * @return array
     */
    public static function controllers()
    {
        $controllers = [];
        if (($config = static::getConfig()) && isset($config['data']['controllers'])) {
            $controllers = $config['data']['controllers'];
        }
        return $controllers;
    }

    /**
     * Конфигурационный массив контроллеров
     * @return array
     */
    public static function models()
    {
        $models = [];
        if (($config = static::getConfig()) && isset($config['data']['models'])) {
            $models = $config['data']['models'];
        }
        return $models;
    }

    /**
     * Регистрация компонента фронт-контроллера
     * @param $name
     * @param $definition
     * @throws InvalidComponentClassException
     * @return bool
     */
    public function registerComponent($name, $definition)
    {
        $config = null;
        if (is_array($definition)) {
            $className = null;
            if (isset($definition['class'])) $className = $definition['class'];
            elseif (isset($this->_defaultComponentClasses[$name])) $className = $this->_defaultComponentClasses[$name];
            unset($definition['class']);
            if (!empty($definition)) $config = $definition;
        } elseif (is_string($definition)) {
            $className = $definition;
        }
        if (class_exists($className)) {
            $this->_knownComponents[$name] = [
                'class'  => $className,
                'config' => $config
            ];
            return true;
        } else {
            throw new InvalidComponentClassException([$this, $name, $config]);
        }
    }

    /**
     * AbstractModule constructor.
     * Разбор конфигурационного массива при создании фронт-контроллера
     */
    public function __construct()
    {
        if (!empty($components = static::components())) foreach ($components as $name => $definition) {
            $this->registerComponent($name, $definition);
        }
        $this->_knownControllers = static::controllers();
        $this->_knownModels = static::models();
    }
}