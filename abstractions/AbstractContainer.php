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
     * Создание экземпляра класса на основе прототипа, определяемого владельцем контейнера
     * @param $config
     * @return mixed
     */
    abstract protected function getClassNameFor($config);

    /**
     * Уровень фронт-контроллера, которому принадлежит данный контейнер
     * @var Hierarchical
     */
    protected $owner;

    protected $registered = [];

    protected $registeredClasses = [];

    protected $instantiated = [];

    protected function instantiate($tag)
    {
        if (!isset($this->instantiated[$tag])) {

        }
    }

    final public function register($tag, $definition)
    {
        if (!isset($this->registered[$tag])) {
            $className = $config = null;
            if (is_string($definition) && file_exists($definition)) {
                $definition = \Devil::loadConfigFile($definition);
            } elseif (is_string($definition) && class_exists($definition)) {
                $className = $definition;
                $config = $className::getConfig();
            }
            if (is_array($definition)) {
                if (isset($definition['class'])) {
                    $className = $definition['class'];
                    unset($definition['class']);
                }
                $config = array_merge($className::getConfig(), $definition);
            }
            $this->registered[$tag] = [
                'class'  => $className,
                'config' => $config,
            ];
            $this->registeredClasses[$className] = $tag;
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