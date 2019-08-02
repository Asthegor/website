<?php
class Singleton
{
    private static $instance = null;
    private $dbpdo;

    private function __construct()
    {
        try
        {
            $this->dbpdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, 
                                   DB_USER, 
                                   DB_PWD, 
                                   array(PDO::ATTR_PERSISTENT => true));
            $this->dbpdo->query('SET NAMES UTF8');
        }
        catch (PDOException $e)
        {
            print $e->getMessage()."<br/>";
            die();
        }
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Singleton();
        }
        return self::$instance->dbpdo;
    }
}


?>