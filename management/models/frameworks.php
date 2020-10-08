<?php

class FrameworksModel extends Model
{
    private $returnPage = 'frameworks';
    
    public function Index()
    {
        $this->query('SELECT fe.id, fe.name, fe.sortOrder, fe.bVisible, pl.name proglanguage
                      FROM framework AS fe
                        INNER JOIN proglanguage AS pl on fe.id_ProgLanguage = pl.id
                      ORDER BY fe.bVisible DESC, fe.sortOrder ASC');
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
            }
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                //Insertion des données générales
                $this->query('INSERT INTO framework (name, id_ProgLanguage, sortOrder, bVisible)
                            VALUES (:name, :proglanguage, :sortOrder, :bVisible)');
                $this->bind(':name', $post['name']);
                $this->bind(':proglanguage', $post['proglanguage']);
                $this->bind(':sortOrder', $post['sortOrder'], PDO::PARAM_INT);
                $this->bind(':bVisible', isset($post['bVisible']), PDO::PARAM_INT);
                $this->execute();
                $id = $this->lastIndexId();
                //Verify
                if($id)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert: $id='.$id, 'error');
            }
        }
        return;
    }

    public function Update()
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
                $this->query('UPDATE framework 
                            SET name = :name, id_ProgLanguage = :proglanguage, sortOrder = :sortOrder, bVisible = :bVisible
                            WHERE id = :id');
                $this->bind(':name', $post['name']);
                $this->bind(':proglanguage', $post['proglanguage']);
                $this->bind(':sortOrder', $post['sortOrder']);
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $this->bind(':id', $post['id']);
                $res = $this->execute();
                $this->close();
                if($res)
                {
                    $this->returnToPage($this->returnPage);
                }
                Messages::setMsg('Error(s) during update', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT id, name, sortOrder, bVisible, id_ProgLanguage
                      FROM framework
                      WHERE id = :id");
        $this->bind(':id', $get['id']);
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
            $this->query('DELETE FROM framework WHERE id = :id');
            $this->bind(':id', $post['id']);
            $res = $this->execute();
            if (!$res)
            {
                Messages::setMsg('Record used by a project.', 'error');
            }
            $this->close();
            $this->returnToPage($this->returnPage);
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT fe.id, fe.name, pl.name proglanguage 
                      FROM framework AS fe
                        INNER JOIN proglanguage AS pl ON fe.id_ProgLanguage = pl.id
                      WHERE fe.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage($this->returnPage);
        }
        return $rows;
    }

    public function getList()
    {
        $this->query("SELECT fe.id, CONCAT(fe.name, ' (', pl.name, ')') name
                      FROM framework AS fe
                        INNER JOIN proglanguage AS pl on fe.id_ProgLanguage = pl.id");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>