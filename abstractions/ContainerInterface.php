<?php
namespace PhpDevil\abstractions;

interface ContainerInterface
{
    /**
     * Регистрация компонента в контейнере по тегу и определению
     * @param $tag
     * @param $definition
     * @return mixed
     */
    public function register($tag, $definition);
}