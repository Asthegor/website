<?php

class TutorialsModel extends Model
{
    private $returnPage = "tutorials";
    public function Index()
    {
        $this->query("SELECT t.id, t.title, t.short_desc, ".
                            "t.date_update, pl.name AS proglanguage ".
                     "FROM tutorial AS t ".
                        "INNER JOIN proglanguage AS pl ON t.id_ProgLanguage = pl.id ");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            if ($post['title'] == '' || $post['short_desc'] == '' || $post['content'] == '' || $post['proglanguage'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                //Insertion des données générales
                $this->query('INSERT INTO tutorial(title, short_desc, content, id_ProgLanguage, id_Previous, id_Next, date_creation, date_update, bVisible)
                            VALUES (:title, :short_desc, :content, :id_ProgLanguage, :id_Previous, :id_Next, :date_creation, :date_update, :bVisible)');
                $this->bind(':title', $post['title']);
                $this->bind(':short_desc', $post['short_desc']);
                $this->bind(':content', $post['content']);
                $this->bind(':id_ProgLanguage', $post['proglanguage'], PDO::PARAM_INT);
                $this->bind(':id_Previous', $post['id_previous'], PDO::PARAM_INT);
                $this->bind(':id_Next', $post['id_next'], PDO::PARAM_INT);
                $this->bind(':date_creation', date("Y-m-d"));
                $this->bind(':date_update', date("Y-m-d"));
                $this->bind(':bVisible', isset($post['bVisible']), PDO::PARAM_INT);
                $this->execute();
                $id = $this->lastIndexId();
                //Verify
                if($id)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
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
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            if ($post['title'] == '' || $post['short_desc'] == '' || $post['content'] == '' || $post['proglanguage'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                //Insertion des données générales
                $this->query("UPDATE tutorial ".
                             "SET title=:title, short_desc=:short_desc, content=:content, ".
                                 "id_ProgLanguage=:id_ProgLanguage, id_Previous=:id_Previous, ".
                                 "id_Next=:id_Next, date_update=:date_update, bVisible=:bVisible ".
                             "WHERE id=:id");
                $this->bind(':title', $post['title']);
                $this->bind(':short_desc', $post['short_desc']);
                $this->bind(':content', $post['content']);
                $this->bind(':id_ProgLanguage', $post['proglanguage'], PDO::PARAM_INT);
                $this->bind(':id_Previous', isset($post['id_previous']) ? $post['id_previous'] : 0, PDO::PARAM_INT);
                $this->bind(':id_Next', isset($post['id_next']) ? $post['id_next'] : 0, PDO::PARAM_INT);
                $this->bind(':date_update', date("Y-m-d"));
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0, PDO::PARAM_INT);
                $this->bind(':id', $post['id']);
                $resp = $this->execute();
                //Verify
                if($resp)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during update: $resp='.$resp, 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        $this->query("SELECT id, title, short_desc, content, id_ProgLanguage, ".
                            "id_Previous, id_Next, date_creation, date_update, bVisible ".
                     "FROM tutorial ".
                     "WHERE id = :id");
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
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['todelete']))
        {
            $this->query('DELETE FROM tutorial WHERE id = :id');
            $this->bind(':id', $post['id']);
            $res = $this->execute();
            if (!$res)
            {
                Messages::setMsg('Record used by a project.', 'error');
            }
            $this->close();
            $this->returnToPage($this->returnPage);
            return;
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        $this->query("SELECT id, title ".
                     "FROM tutorial ".
                     "WHERE id = :id");
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
    
}

?>