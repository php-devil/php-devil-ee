<?php
class Devil
{
    private static $_currentApplication = null;

    /**
     * Загрузка файла конфигурации с кешированием в памяти
     * формат файлов: php|yml|json
     * @param $fileName
     * @return array
     */
    public static function loadConfigFile($fileName)
    {
        return \PhpDevil\Common\Configurator\Loader::getInstance()
            ->load($fileName);
    }

    public static function registerApplication(\PhpDevil\base\ApplicationInterface $app)
    {
        if (null === self::$_currentApplication) {
            self::$_currentApplication = $app;
        } else {
            throw new \PhpDevil\exceptions\RuntimeException([
                'Application is running. Close previous application to register new',
                self::$_currentApplication,
                $app
            ]);
        }
    }

    public static function closeApplication($app)
    {
        if (self::$_currentApplication === $app) {
            self::$_currentApplication = null;
        }
    }
}
