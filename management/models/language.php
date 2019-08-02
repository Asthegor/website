<?php

class LanguageModel extends Model
{
    public $returnPage = 'language';
    
    public function Index()
    {
        $this->query('SELECT id, code, name, image
                      FROM language
                      ORDER BY id');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if ($post['submit'])
        {
            if ($post['code'] == '' || $post['name'] == '' || $post['image'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                //Insertion des données générales
                $this->query('INSERT INTO language (code, name, image)
                            VALUES (:code, :name, :image)');
                $this->bind(':code', $post['code']);
                $this->bind(':name', $post['name']);
                $this->bind(':image', $post['image']);
                $this->execute();
                $id = $this->lastIndexId();
                //Verify
                if($id)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this-returnPage);
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert', 'error');
            }
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            // Contrôle des données
            if ($post['code'] == '' || $post['name'] == '' || $post['image'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                //Mise à jour de la base
                $this->startTransaction();
                // Mise à jour du titre FR
                $this->query('UPDATE language 
                              SET code = :code, name = :name, image = :image
                              WHERE id = :id');
                $this->bind(':code', $post['code']);
                $this->bind(':name', $post['name']);
                $this->bind(':image', $post['image']);
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $res = $this->execute();

                if($res)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                $this->rollBack();
                $this->close();
                Messages::setMsg('Error(s) during update', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT id, code, name, image
                      FROM language
                      WHERE id = :id');
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage($this->returnPage);
        }
        return $rows;
    }

    public function Delete()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->startTransaction();
            
            $this->query('DELETE FROM language WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $res = $this->execute();
            
            if ($res)
                $this->commit();
            else
                $this->rollBack();
            $this->close();
            $this->returnToPage($this->returnPage);
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT id, code, name, image
                      FROM language
                      WHERE id = :id');
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage($this->returnPage);
        }
        return $rows;
    }
    
    public function GetAllLanguageForQuery()
    {
        $this->query('SELECT id, code FROM language');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
  }
}
?>