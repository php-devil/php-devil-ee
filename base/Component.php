<?php
namespace PhpDevil\base;
use PhpDevil\abstractions\AbstractComponent;
use PhpDevil\exceptions\InvalidConfigParamException;

/**
 * Class Component
 * Компонент приложения или модуля.
 * @package PhpDevil\base
 */
abstract class Component extends AbstractComponent implements ComponentInterface
{
    /**
     * Для каждого свойства конфигурации у компонента должен быть метод установки значения.
     *
     * При наличии в массиве конфигурации свойства, для которого не объявлен соответствующий метод установки
     * значения возникает ошибка
     *
     * @param $param
     * @param $config
     * @throws InvalidConfigParamException
     */
    final protected function configure($param, $config)
    {
        $setterMethod = 'configure' . ucfirst($param);
        $setterProperty = '_' . $param;
        if (method_exists($this, $setterMethod)) {
            $this->$setterMethod($config);
        } elseif (property_exists($this, $setterProperty)) {
            $this->$setterProperty = $config;
        } else {
            throw new InvalidConfigParamException([$param, $this]);
        }
    }

    /**
     * Component constructor.
     * Стандартная конфигурация компонента фронт-контроллера может быть перегружена
     * @param array|null $overrideConfig
     */
    public function __construct(array $overrideConfig = null)
    {
        $config = static::getConfig();
        if (!empty($overrideConfig)) $config = array_merge($config, $overrideConfig);
        if (!empty($config)) foreach ($config as $k=>$v) {
            $this->configure($k, $v);
        }
    }
}