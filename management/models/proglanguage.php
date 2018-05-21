<?php

class ProgLanguageModel extends Model
{
    const curDB = "lacombed_projects";

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query('SELECT id, name
                      FROM proglanguage
                      ORDER BY name');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['name'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            // Insert into MySQL
            $this->changeDatabase(self::curDB);
            //Insertion des données générales
            $this->query('INSERT INTO proglanguage (name)
                          VALUES (:name)');
            $this->bind(':name', $post['name']);
            $this->execute();
            //Verify
            $id = $this->lastIndexId();
            $this->close();
            if($id)
            {
                $this->returnToPage('proglanguage');
            }
            Messages::setMsg('Error(s) during insert', 'error');
        }
        return;
    }

    public function Update()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['submit']))
        {
            // Contrôle des données
            if ($post['name'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                //Mise à jour de la base
                $this->query('UPDATE proglanguage SET name = :name WHERE id = :id');
                $this->bind(':name', $post['name']);
                $this->bind(':id', $post['id']);
                $res = $this->execute();
                $this->close();
                if(!$res)
                {
                    Messages::setMsg('Error(s) during update', 'error');
                }
                else
                {
                    $this->returnToPage('proglanguage');
                }
            }
        }
        $this->query('SELECT id, name
                      FROM proglanguage
                      WHERE id = '.$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage('proglanguage');
        }
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->query('DELETE FROM proglanguage WHERE id = :id');
            $this->bind(':id', $_GET['id']);
            $res = $this->execute();
            if (!$res)
            {
                Messages::setMsg('Record used by a framework/engine.', 'error');
            }
            $this->close();
            $this->returnToPage('proglanguage');
        }
        $this->query('SELECT name
                      FROM proglanguage
                      WHERE id = '.$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage('proglanguage');
        }
        return $rows;
    }

    public function getList()
    {
        $this->changeDatabase(self::curDB);
        $this->query('SELECT id, name
                      FROM proglanguage
                      ORDER BY name');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}
?>