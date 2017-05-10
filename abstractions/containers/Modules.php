<?php
namespace PhpDevil\abstractions\containers;
use PhpDevil\abstractions\AbstractContainer;
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
}