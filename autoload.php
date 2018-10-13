<?php
function LoadClasses($class)
{
    $fullname = 'classes/' . $class . '.php';
    if (!file_exists($fullname))
    {
        return false;
    }
    require_once $fullname;
    return true;
}
function LoadControllers($class)
{
    $fullname = 'controllers/' . $class . '.php';
    if (!file_exists($fullname))
    {
        return false;
    }
    require_once $fullname;
    return true;
}
function LoadModels($class)
{
    $fullname = 'models/' . str_replace("Model", "", $class) . '.php';
    if (!file_exists($fullname))
    {
        return false;
    }
    require_once $fullname;
    return true;
}
spl_autoload_register('LoadClasses');
spl_autoload_register('LoadControllers');
spl_autoload_register('LoadModels');

?>