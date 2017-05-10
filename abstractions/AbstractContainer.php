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

    public function register($tag, $definition)
    {
        if (!isset($this->registered[$tag])) {
            $this->registered[$tag] = $definition;
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