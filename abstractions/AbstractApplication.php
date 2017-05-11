<?php
namespace PhpDevil\abstractions;

abstract class AbstractApplication extends AbstractModule
{
    protected $_knownModulesTags = [];

    protected $_knownModulesClasses = [];

    protected function registerModule($tag, $def)
    {
        if (is_string($def) && class_exists($def)) {
            $moduleFrontController = new $def;
            $moduleFrontController->setOwner($this);
        } else {
            die ('Module must be a front-controller');
        }
    }

    public function configureModules($modules)
    {
        foreach ($modules as $tag=>$def) {
            $this->registerModule($tag, $def);
        }
    }
}