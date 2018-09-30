<?php

// Année de début du copyright
define("COPY_YEAR","2018");
// Définition du fuseau horaire
date_default_timezone_set("Europe/Paris");


//Define DB Params
//define("DB_PORT", "");
define("DB_PORT", ":3399");
define("DB_HOST", "localhost".DB_PORT);
define("DB_NAME", "lacombed_web");

//define("DB_USER_PREF", "lacombed_");
define("DB_USER_PREF", "");
define("DB_USER", DB_USER_PREF."user_ro");
define("DB_PWD", "1SlOn7AEmp@W");

// Define URL
//define("ROOT_URL", "https://php.lacombedominique.com/");
define("ROOT_URL", "http://localhost:8090/");
define("ROOT_PATH", "");
define("ROOT_MNGT", ROOT_URL.ROOT_PATH);

?>
