<?php
namespace PhpDevil\abstractions;

abstract class AbstractController extends AbstractConfigurable implements ControllerInterface
{
    protected $owner = null;
}