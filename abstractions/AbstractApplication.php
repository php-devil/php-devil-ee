<?php
namespace PhpDevil\abstractions;

abstract class AbstractApplication extends AbstractModule
{
    protected $_knownModules = [];

    public function configureModules($modules)
    {
        $this->configureComponentContainer('_knownModules', $modules);
    }
}