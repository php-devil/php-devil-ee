<?php
namespace PhpDevil\data;

abstract class ActiveRecord extends ActiveForm
{
    /**
     * Для ActiveRecord - схема связанной таблицы БД, для ActiveForm - null
     * @return array|null
     */
    public static function schema()
    {
        if (($config = static::getConfig()) && isset($config['schema'])) {
            return $config['schema'];
        } else {
            //todo: тут должна возникать ошибка связи модели с таблицей БД
            return null;
        }
    }
}