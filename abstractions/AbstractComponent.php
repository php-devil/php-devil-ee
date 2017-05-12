<?php
namespace PhpDevil\abstractions;


class AbstractComponent
{
    protected $owner = null;

    /**
     * Полный путь к конфигурационному файлу при его наличии
     * @return string|null
     */
    public static function getConfigSource()
    {
        return null;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Полный массив конфигурации
     * @return array|mixed
     */
    public static function getConfig()
    {
        $config = [];
        if ($fileName = static::getConfigSource()) {
            $config = \Devil::loadConfigFile($fileName);
        }
        return $config;
    }
}