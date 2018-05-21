<?php

class FrameworksModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query('SELECT fe.id, fe.name, fe.bVisible, pl.name proglanguage
                      FROM frameworkengine AS fe
                        INNER JOIN proglanguage AS pl on fe.id_ProgLanguage = pl.id
                      ORDER BY fe.bVisible DESC, fe.name');
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
            $this->startTransaction();
            //Insertion des données générales
            $this->query('INSERT INTO frameworkengine (name, id_ProgLanguage, bVisible)
                          VALUES (:name, :proglanguage, :bVisible)');
            $this->bind(':name', $post['name']);
            $this->bind(':proglanguage', $post['proglanguage']);
            $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
            $this->execute();
            $id = $this->lastIndexId();

            //Verify
            if($id)
            {
                $this->commit();
                $this->close();
                $this->returnToPage('frameworks');
            }
            $this->rollback();
            $this->close();
            Messages::setMsg('Error(s) during insert', 'error');
        }
        return;
    }

    public function Update()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['name'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            $this->query('UPDATE frameworkengine 
                          SET name = :name, id_ProgLanguage = :proglanguage, bVisible = :bVisible
                          WHERE id = :id');
            $this->bind(':name', $post['name']);
            $this->bind(':proglanguage', $post['proglanguage']);
            $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
            $this->bind(':id', $post['id']);
            $res = $this->execute();
            $this->close();
            if($res)
            {
                $this->returnToPage('frameworks');
            }
            else
            {
                Messages::setMsg('Error(s) during update', 'error');
            }
        }
        $this->query("SELECT id, name, bVisible, id_ProgLanguage
                      FROM frameworkengine
                      WHERE id = ".$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$_GET['id'].'" not found', 'error');
            $this->returnToPage('frameworks');
        }
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->query('DELETE FROM frameworkengine WHERE id = :id');
            $this->bind(':id', $_GET['id']);
            $res = $this->execute();
            if (!$res)
            {
                Messages::setMsg('Record used by a project.', 'error');
            }
            $this->close();
            $this->returnToPage('frameworks');
        }
        $this->query("SELECT fe.name, pl.name proglanguage 
                      FROM frameworkengine AS fe
                        INNER JOIN proglanguage AS pl ON fe.id_ProgLanguage = pl.id
                      WHERE fe.id = ".$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$_GET['id'].'" not found', 'error');
            $this->returnToPage('frameworks');
        }
        return $rows;
    }

    public function getList()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT fe.id, CONCAT(fe.name, ' (', pl.name, ')') name
                      FROM frameworkengine AS fe
                        INNER JOIN proglanguage AS pl on fe.id_ProgLanguage = pl.id");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>