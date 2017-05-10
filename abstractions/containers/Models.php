<?php
namespace PhpDevil\abstractions\containers;
use PhpDevil\abstractions\AbstractContainer;
use PhpDevil\base\ModelInterface;

class Models extends AbstractContainer
{
    /**
     * @inheritdoc
     */
    public static function getAllowedElementInterface()
    {
        return ModelInterface::class;
    }
}