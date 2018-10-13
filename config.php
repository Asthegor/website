<?php

// Année de début du copyright
define("COPY_YEAR","2018");
// Définition du fuseau horaire
date_default_timezone_set("Europe/Paris");


//Define DB Params
define("DB_PORT", "");
// define("DB_PORT", ":3399");
define("DB_HOST", "localhost".DB_PORT);
define("DB_NAME", "lacombed_web");

//define("DB_USER_PREF", "lacombed_");
define("DB_USER_PREF", "");
define("DB_USER", DB_USER_PREF."user_ro");
define("DB_PWD", "1SlOn7AEmp@W");

// Define URL
//define("ROOT_URL", "https://php.lacombedominique.com/");
define("ROOT_URL", "http://127.0.0.1/website_php/");
define("ROOT_PATH", "");
define("ROOT_MNGT", ROOT_URL.ROOT_PATH);

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
