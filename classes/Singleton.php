<?php
class Singleton
{
    private static $instance = null;
    private $dbname;
    private $dbuser;
    private $dbpdo;

    private function __construct($dbname, $dbuser, $dbpwd)
    {
        $this->dbname = $dbname;
        $this->dbuser = $dbuser;
        try
        {
            $this->dbpdo = new PDO("mysql:host=".DB_HOST.";dbname=".$dbname, $dbuser, $dbpwd);
        }
        catch (PDOException $e)
        {
            print $e->getMessage()."<br/>";
            die();
        }
    }
    private function CompareOptions($dbname, $dbuser)
    {
        return ($this->dbname === $dbname && $this->dbuser === $dbuser);
    }

    public static function getInstance($dbname, $dbuser, $dbpwd)
    {
        if(is_null(self::$instance) || !self::$instance->CompareOptions($dbname, $dbuser))
        {
            self::$instance = new Singleton($dbname, $dbuser, $dbpwd);
        }
        return self::$instance->dbpdo;
    }
}


?>