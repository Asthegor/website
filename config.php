<?php

// Année de début du copyright
define("COPY_YEAR","2015");
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
//define("ROOT_URL", "http://php.lacombedominique.com/");
define("ROOT_URL", "http://localhost:8090/");
define("ROOT_PATH", "");
define("ROOT_MNGT", ROOT_URL.ROOT_PATH);










// $web_bdd = new mysqli(DB_HOST, DB_USER, "user_web", "lacombed_web");
// if (mysqli_connect_errno())
// {
//     echo'Erreur de connexion (base=web) : '.mysqli_connect_error();
//     exit();
// }
// mysqli_set_charset($web_bdd, 'utf8');

// $prj_bdd = new mysqli(DB_HOST, DB_USER, "user_web", "lacombed_projects");
// if (mysqli_connect_errno())
// {
//     echo'Erreur de connexion (base=projects) : '.mysqli_connect_error();
//     exit();
// }
// mysqli_set_charset($prj_bdd, 'utf8');

// $exp_bdd = new mysqli(DB_HOST, DB_USER, "user_web", "lacombed_experiences");
// if (mysqli_connect_errno())
// {
//     echo'Erreur de connexion (base=experiences) : '.mysqli_connect_error();
//     exit();
// }
// mysqli_set_charset($exp_bdd, 'utf8');

?>