<?php
namespace PhpDevil\abstractions;

use PhpDevil\base\Hierarchical;

abstract class AbstractContainer implements ContainerInterface
{
    /**
     * Обязательный интерфейс компонента, который может содержаться в данном контейнере
     * @return string
     */
    abstract public static function getAllowedElementInterface();

    /**
     * Уровень фронт-контроллера, которому принадлежит данный контейнер
     * @var Hierarchical
     */
    protected $owner;

    protected $registered = [];

    protected $instantiated = [];

    protected function instantiate($tag)
    {
        if (!isset($this->instantiated[$tag])) {
            $def = $this->registered[$tag];
            if (is_string($tag)) {
                if (class_exists($def)) $this->instantiated[$tag] = $def;
                elseif (file_exists($def)) $def = require $def;
            }
        }
    }

    final public function register($tag, $definition)
    {
        if (!isset($this->registered[$tag])) {
            $this->registered[$tag] = $definition;
        }
    }

    final public function hasComponent($tag)
    {
        return isset($this->registered[$tag]);
    }

    public function loadComponent($tag)
    {
        if ($this->hasComponent($tag)) {
            $this->instantiate($tag);
            return $this->instantiated[$tag];    
        } else {
            //todo: trugger error: unregistered element
        }
    }

    final protected function __construct(Hierarchical $owner)
    {
        $this->owner = $owner;
    }

    public static function createContainer(Hierarchical $owner, $type)
    {
        $class = '\\PhpDevil\\abstractions\\containers\\' . ucfirst($type);
        return new $class($owner);
    }
}