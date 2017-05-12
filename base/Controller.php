<?php
namespace PhpDevil\base;
use PhpDevil\abstractions\AbstractController;

class Controller extends AbstractController implements ControllerInterface
{
    public function performAction($name, $param = [])
    {
        $methodName = 'action' . ucfirst($name);
        return call_user_func_array([$this, $methodName], $param);
    }
}