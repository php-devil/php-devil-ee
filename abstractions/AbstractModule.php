<?php
namespace PhpDevil\abstractions;

abstract class AbstractModule extends AbstractController
{
    protected $_knownComponents = [];

    protected $_knownModels = [];

    protected $_knownControllers = [];

    public static function getDefaultComponents()
    {
        return null;
    }

    public function configureComponentContainer($container, $definitions, $defaultTagClasses = null)
    {
        if ('_knownComponents' === $container) {
            foreach ($definitions as $tag=>$def) {
                $config = [];
                $className = null;
                $needInterface = null;
                if (is_string($def)) $className = $def;
                else {
                    if (isset($def['class'])) $className = $def['class'];
                    unset($def['class']);
                }
                if (!empty($def)) $config = $def;
                if (null === $className) {
                    if (isset($defaultTagClasses[$tag]['class'])) {
                        $className = $defaultTagClasses[$tag]['class'];
                    }
                }
                if ($className) {
                    if (isset($defaultTagClasses[$tag]['interface'])) $needInterface = $defaultTagClasses[$tag]['interface'];
                    if (class_exists($className)) {
                        $this->$container[$tag] = [
                            'class'     => $className,
                            'interface' => $needInterface,
                            'config'    => $config,
                        ];
                    }
                }
            }
        } else {
            $this->$container = $definitions;
        }

    }



    public function configureComponents($components)
    {
        $this->configureComponentContainer('_knownComponents', $components, static::getDefaultComponents());
    }

    public function configureModels($models)
    {
        $this->configureComponentContainer('_knownModels', $models);
    }

    public function configureControllers($controllers)
    {
        $this->configureComponentContainer('_knownControllers', $controllers);
    }
}