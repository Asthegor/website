<?php

class CompanyModel extends Model
{
    const curDB = "lacombed_experiences";

    public function Index()
    {
        return $this->getList();
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['name'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->changeDatabase(self::curDB);
                //Insertion des données générales
                $this->query('INSERT INTO company (name)
                            VALUES (:name)');
                $this->bind(':name', $post['name']);
                $this->execute();
                //Verify
                $id = $this->lastIndexId();
                $this->close();
                if($id)
                {
                    $this->returnToPage('company');
                }
                Messages::setMsg('Error(s) during insert', 'error');
            }
        }
        return;
    }

    public function Update()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
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
                $this->query('UPDATE company SET name = :name WHERE id = :id');
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
                    $this->returnToPage('company');
                }
            }
        }
        $this->query('SELECT id, name FROM company WHERE id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage('company');
        }
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->query('DELETE FROM company WHERE id = :id');
            $this->bind(':id', $post['id']);
            $res = $this->execute();
            if (!$res)
            {
                Messages::setMsg('Record used by an experience.', 'error');
            }
            $this->close();
            $this->returnToPage('company');
        }
        $this->query('SELECT id, name FROM company WHERE id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage('company');
        }
        return $rows;
    }

    public function getList()
    {
        $this->changeDatabase(self::curDB);
        $this->query('SELECT id, name
                      FROM company
                      ORDER BY name');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}
?>