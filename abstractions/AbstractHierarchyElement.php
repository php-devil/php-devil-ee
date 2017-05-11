<?php
namespace PhpDevil\abstractions;

abstract class AbstractHierarchyElement
{
    /**
     * Зарезервированные имена контейнеров, доступных на данном уровне
     * @return array
     */
    abstract protected static function getAllowedContainers();

    protected $owner = null;

    protected $tagName = null;

    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    public function setTagName($tag)
    {

    }

    /**
     * Полный путь к конфигурационному файлу компонента при его наличии
     * @return string|null
     */
    public static function getConfigSource()
    {
        return null;
    }

    /**
     * Возможность определить конфигурацию компонента в одном статическом методе
     * По умолчанию возвращает содержимое конфигурационного файла
     * return array
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
     * Зарезервированные события для обращения из контейнеров и дополнения
     * методов, запрещенных для перегрузки
     */
    protected function onBeforeConstruct() {}
    protected function onAfterConstruct() {}
}