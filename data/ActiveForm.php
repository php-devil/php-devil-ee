<?php
namespace PhpDevil\data;
use PhpDevil\abstractions\AbstractModel;

abstract class ActiveForm extends AbstractModel
{
    /**
     * У формы не может быть соединения с таблицей БД
     * @return array|null
     */
    public static function schema()
    {
        return null;
    }
}