<?php

abstract class Model
{
    protected $dbh;
    protected $stmt;

    public function __construct()
    {
        $this->dbh = Singleton::getInstance();
        $this->dbh->query('SET NAMES UTF8');
    }
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type))
        {
            switch(true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastIndexId()
    {
        return $this->dbh->lastInsertId();
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function close()
    {
        $this->stmt->closeCursor();
    }

    protected function returnToPage($path)
    {
        header('Location: '.ROOT_MNGT.$path);
    }
    
    protected function createSlug($text)
    {
        $text = strtolower(urldecode($text));
        $unwanted_array = [
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'ç' => 'c', 
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
            'ñ' => 'n', 
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 
            'ý' => 'y', 'ÿ' => 'y'
        ];
        $text = strtr($text, $unwanted_array);
        $text = str_replace(['-', ' ', '.', '(', ')'], '_', $text);
        $text = preg_replace('/[^a-z0-9_]/', '', $text);
        $text = preg_replace('/_+/', '_', $text);
        return trim($text, '_');
    }
    public function column($columnIndex = 0)
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN, $columnIndex);
    }
}
?>