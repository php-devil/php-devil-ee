<?php
namespace PhpDevil\abstractions;

abstract class AbstractModule extends AbstractController
{
    protected $_knownComponents = [];

    protected $_knownModels = [];

    protected $_knownControllers = [];

    protected function registerComponent($tag, $class)
    {
        $this->_knownComponents[$tag] = $class;
    }

    public function configureComponents($components)
    {
        foreach ($components as $tag=>$class) {
            $this->registerComponent($tag, $class);
        }
    }

    protected function registerModel($tag, $class)
    {
        $this->_knownModels[$tag] = $class;
    }

    public function configureModels($models)
    {
        foreach ($models as $tag=>$class) {
            $this->registerModel($tag, $class);
        }
    }

    protected function registerController($tag, $class)
    {
        $this->_knownControllers[$tag] = $class;
    }

    public function configureControllers($controllers)
    {
        foreach ($controllers as $tag=>$class) {
            $this->registerController($tag, $class);
        }
    }
}