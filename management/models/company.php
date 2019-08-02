<?php

class CompanyModel extends Model
{
    private $returnPage = 'company';
    
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
                //Insertion des données générales
                $this->query('INSERT INTO company (name) VALUES (:name)');
                $this->bind(':name', $post['name']);
                $this->execute();
                //Verify
                $id = $this->lastIndexId();
                $this->close();
                if($id)
                {
                    $this->returnToPage($this->returnPage);
                }
                else
                {
                    Messages::setMsg('Error(s) during insert', 'error');
                }
            }
        }
    }

    public function Update()
    {
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
                    $this->returnToPage($this->returnPage);
                }
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT id, name FROM company WHERE id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage($this->returnPage);
        }
        return $rows;
    }

    public function Delete()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
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
            $this->returnToPage($this->returnPage);
            return;
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT id, name FROM company WHERE id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage($this->returnPage);
        }
        return $rows;
    }

    public function getList()
    {
        $this->query('SELECT id, name
                      FROM company
                      ORDER BY name');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}
?>