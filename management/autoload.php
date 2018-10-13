<?php
function LoadManagementClasses($class)
{
    $fullname = 'management/classes/' . $class . '.php';
    if (!file_exists($fullname))
    {
        return false;
    }
    require_once $fullname;
    return true;
}
function LoadManagementControllers($class)
{
    $fullname = 'management/controllers/' . $class . '.php';
    if (!file_exists($fullname))
    {
        return false;
    }
    require_once $fullname;
    return true;
}
function LoadManagementModels($class)
{
    $fullname = 'management/models/' . str_replace("Model", "", $class) . '.php';
    if (!file_exists($fullname))
    {
        return false;
    }
    require_once $fullname;
    return true;
}
spl_autoload_register('LoadManagementClasses');
spl_autoload_register('LoadManagementControllers');
spl_autoload_register('LoadManagementModels');

?>