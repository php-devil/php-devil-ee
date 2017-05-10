<?php
namespace PhpDevil\base;
use PhpDevil\abstractions\AbstractContainer;
use PhpDevil\abstractions\AbstractHierarchyElement;
use PhpDevil\abstractions\ContainerInterface;

abstract class Module extends AbstractHierarchyElement implements ModuleInterface
{
    /**
     * Зарезервированные имена контейнеров, доступных на данном уровне
     * @return array
     */
    protected static function getAllowedContainers()
    {
        return ['components', 'models', 'controllers', 'modules'];
    }

    /**
     * Зарегистрированные на данном уровне компоненты
     * @var ContainerInterface
     */
    protected $components = null;

    /**
     * Зарегистрированные на данном уровне контроллеры
     * @var ContainerInterface
     */
    protected $controllers = null;

    /**
     * Зарегистрированные на данном уровне подмодули
     * @var ContainerInterface
     */
    protected $modules;

    /**
     * Зарегистрированные на данном уровне модели
     * @var ContainerInterface
     */
    protected $models;

    /**
     * @param $name
     * @return ContainerInterface
     */
    final public function getContainer($name)
    {
        if (in_array($name, static::getAllowedContainers())) {
            if (null === $this->$name) {
                $this->$name = AbstractContainer::createContainer($this, $name);
            }
            return $this->$name;
        } else {
            //todo: trigger error - container $name is not allowed here
        }
    }

    final public function __construct($configuration = null)
    {
        $this->onBeforeConstruct();
        if (null === $configuration) $configuration = static::getConfig();
        if (is_array($containers = static::getAllowedContainers())) foreach ($containers as $name) {
            if (isset($configuration[$name]) && is_array($configuration[$name])) {
                foreach ($configuration[$name] as $tag=>$def) $this->getContainer($name)->register($tag, $def);
            }
        }
        $this->onAfterConstruct();
    }


}