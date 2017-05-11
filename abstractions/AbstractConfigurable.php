<?php
namespace PhpDevil\abstractions;

use PhpDevil\exceptions\InvalidConfigParam;

abstract class AbstractConfigurable
{
    /**
     * Полный путь к файлу конфигурации компонента
     * @return null
     */
    public static function getConfigSource()
    {
        return null;
    }

    /**
     * Загрузка файла конфигурации компонента по умолчанию.
     * Может быть переопределено на возврат массива конфигурации со значениями по умолчанию.
     * @return array
     */
    public static function getConfig()
    {
        if (($fileName = static::getConfigSource()) && file_exists($fileName)) {
            return \Devil::loadConfigFile($fileName);
        } else {
            return [];
        }
    }

    /**
     * Автоконфигурирование по массиву конфигурации.
     * Переданный массив переопределяет щначения по умолчанию.
     * @param array $config
     * @throws InvalidConfigParam
     */
    final protected function configureFromArray(array $config = null)
    {
        if (null === $config) $config = [];
        $config = array_merge(static::getConfig(), $config);
        if (!empty($config)) foreach ($config as $k=>$v) {
            $setterMethod = 'configure' . ucfirst($k);
            if (method_exists($this, $setterMethod)) $this->$setterMethod($v);
            elseif (property_exists($this, $k)) $this->$k = $v;
            else {
                throw new InvalidConfigParam([$k, $this]);
            }
        }
    }
}