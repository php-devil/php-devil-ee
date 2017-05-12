<?php
class Devil
{
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
}
