<?php
class Devil
{
    public static function loadConfigFile($fileName)
    {
        return require $fileName;
    }
}
