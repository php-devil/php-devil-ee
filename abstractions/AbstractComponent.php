<?php
namespace PhpDevil\abstractions;


class AbstractComponent
{
    /**
     * Полный путь к конфигурационному файлу при его наличии
     * @return string|null
     */
    public static function getConfigSource()
    {
        return null;
    }

    /**
     * Полный массив конфигурации
     * @return array|mixed
     */
    public static function getConfig()
    {
        if ($fileName = static::getConfigSource()) {
            return \Devil::loadConfigFile($fileName);
        } else {
            return [];
        }
    }
}