<?php
class Devil
{
    private static $classToTag = [];

    public static function rememberTagOfClass()
    {

    }

    public static function loadConfigFile($fileName)
    {
        return require $fileName;
    }
}
