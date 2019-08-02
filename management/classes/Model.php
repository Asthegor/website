<?php

abstract class Model
{
    protected $stmt;

    public function query($query)
    {
        $this->stmt = Singleton::getInstance()->prepare($query);
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
        return Singleton::getInstance()->lastInsertId();
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function startTransaction()
    {
        Singleton::getInstance()->beginTransaction();
    }
    public function rollBack()
    {
        Singleton::getInstance()->rollBack();
    }
    public function commit()
    {
        Singleton::getInstance()->commit();
    }
    public function close()
    {
        $this->stmt->closeCursor();
        $this->stmt = null;
        $this->dbh = null;
    }

    protected function returnToPage($path)
    {
        header('Location: '.ROOT_MNGT.$path);
    }
    
    private function getLanguages()
    {
        $this->query('SELECT id, code FROM language');
        $languages = $this->resultSet();
        $this->close();
        return $languages;
    }
    protected function generateLanguageQueryJoin($tableSource, $aliasTableSource, $tableLinked, $fieldsToDisplay, $useTableName, $fieldsNewNames)
    {
        $languages = $this->getLanguages();
        $jointures = array();
        $fields = array();

        foreach ($languages as $language)
        {
            $alias = substr($tableLinked, 0, 4).$language['code'];
            $jointures[] = ' INNER JOIN '.$tableLinked.' AS '.$alias.' ON '.$aliasTableSource.'.id = '.$alias.'.id AND '.$alias.'.id_Language = '.$language['id'].' ';
            
            $fieldsNames = empty($fieldsNewNames) ? $fieldsToDisplay : $fieldsNewNames;
            if(is_array($fieldsToDisplay))
                for($index = 0; $index < $$fieldsToDisplay.count(); $index++)
                    $fields[] = $alias.'.'.$fieldsToDisplay[$index].' '.strtolower(($useTableName ? $tableSource : $fieldsNames[$index]).'_'.$language['code']);
            else
                $fields[] = $alias.'.'.$fieldsToDisplay.' '.strtolower(($useTableName ? $tableSource : $fieldsNames).'_'.$language['code']);
        }
        return array('Fields' => $fields, 'Jointures' => $jointures);
    }
    
    protected function insertLanguageValues($table, $values)
    {
        $languages = $this->getLanguages();
        
        $res = array();
        foreach ($languages as $language)
        {
/*          $this->query('INSERT INTO experience_tr (id, id_Language, title, content)
                            VALUES(:id, 1, :title, :content)');
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':content', $post['content_fr']);
                $respfr = $this->execute(); */
            
            $codeLanguage = $language['code'];
            $filteredArray = array_filter($values,
                                          function($key) use ($codeLanguage)
                                          {
                                              $key = strtolower($key);
                                              $language = strtolower($codeLanguage);
                                              return (substr($key, strlen($language) * -1) === $language);
                                          },
                                          ARRAY_FILTER_USE_KEY);
            
            $query = 'INSERT INTO '.$table.'(id, id_Language,';
            // ajout des colonnes
            foreach($filteredArray as $key => $value)
            {
                $query .= substr($key, 0, strlen('_'.$codeLanguage) * -1).',';
            }
            $query = substr($query, 0, -1);
            $query .= ') VALUES(:id,'.$language['id'].',';
            // ajout des tags pour le bind
            foreach($filteredArray as $key => $value)
            {
                $query .= ':'.substr($key, 0, strlen('_'.$codeLanguage) * -1).',';
            }
            $query = substr($query, 0, -1);
            $query .= ')';
            
            $temp = $query;
            foreach($filteredArray as $key => $value)
            {
                $temp = str_replace(':'.substr($key, 0, strlen('_'.$codeLanguage) * -1), "'".$values[$key]."'", $temp);
            }
            $temp = str_replace(':id', $values['id'], $temp);
            var_dump($query);
            echo '<br>';
            var_dump($temp);
            echo '<hr>';
            die();
            
            
            
            $this->query($query);
            $this->bind(':id', $values['id'], PDO::PARAM_INT);
            // data binding
            foreach($filteredArray as $key => $value)
            {
                $bindKey = ':'.substr($key, strlen($codeLanguage) * -1);
                $bindValue = $values[$key];
                $this->bind($bindKey, $bindValue);
            }
            $resp = $this->execute();
            $res[$codelanguage]= (int)$resp;
        }
        return $res;
    }
}
?>