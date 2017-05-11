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

    protected function createClassFromDefault($config)
    {
        // TODO: Implement createClassFromDefault() method.
    }

    public function loadComponent($tag)
    {
        $this->instantiate($tag);
        return clone($this->instantiated[$tag]);
    }
}