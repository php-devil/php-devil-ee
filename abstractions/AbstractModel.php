<?php
namespace PhpDevil\abstractions;

class AbstractModel extends AbstractComponent
{
    /**
     * Атрибуты модели
     * @var array
     */
    private $_attribtues = [];

    /**
     * Конфигурационный массив атрибутов
     * @return array
     */
    public static function attributes()
    {
        if (($config = static::getConfig()) && isset($config['attributes'])) {
            return $config['attributes'];
        } else {
            return [];
        }
    }

    /**
     * Для ActiveRecord - схема связанной таблицы БД, для ActiveForm - null
     * @return array|null
     */
    abstract public static function schema();

    public static function model()
    {

    }
}