<?php
namespace PhpDevil\abstractions\containers;
use PhpDevil\abstractions\AbstractContainer;
use PhpDevil\base\Module;
use PhpDevil\base\ModuleInterface;

class Modules extends AbstractContainer
{
    /**
     * @inheritdoc
     */
    public static function getAllowedElementInterface()
    {
        return ModuleInterface::class;
    }

    /**
     * @inheritdoc
     */
    protected function getClassNameFor($config)
    {
        return $this->owner->getDefaultModuleClass();
    }

}