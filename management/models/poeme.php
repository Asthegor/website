<?php

class PoemeModel extends Model
{
    private $returnPage = 'poeme';
    public function Index()
    {
        $this->query("SELECT id, title, content, date_creation
                      FROM poeme 
                      ORDER BY date_creation DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if ($post['submit'])
        {
            if ($post['title'] == '' || $post['content'] == '')
            {
                $fields = '';
                if ($post['title'] == '') { $fields .= 'title, '; }
                if ($post['content'] == '') { $fields .= 'content, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->startTransaction();
                //Insertion des données
                $this->query("INSERT INTO poeme (title, content, date_creation)
                            VALUES (:title, :content, :date_creation)");
                $this->bind(':title', $post['title']);
                $this->bind(':content', $post['content']);
                $this->bind(':date_creation', $post['date_creation']);
                $resp = $this->execute();
                //Verify
                if($resp)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.']', 'error');
            }
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if ($post['submit'])
        {
            if ($post['title'] == '' || $post['content'] == '')
            {
                $fields = '';
                if ($post['title'] == '') { $fields .= 'title, '; }
                if ($post['content'] == '') { $fields .= 'content, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->startTransaction();
                //Insertion des données
                $this->query("UPDATE poeme
                              SET title = :title, content = :content,
                              date_creation = :date_creation
                              WHERE id = :id");
                $this->bind(':title', $post['title']);
                $this->bind(':content', $post['content']);
                $this->bind(':date_creation', $post['date_creation']);
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $resp = $this->execute();
                //Verify
                if($resp)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during update : [resp='.$resp.']', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT id, title, content, date_creation
                      FROM poeme
                      WHERE id = :id");
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function Delete()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->startTransaction();
            $this->query('DELETE FROM poeme WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resp = $this->execute();
            if ($resp)
                $this->commit();
            else
                $this->rollBack();
            $this->close();
            $this->returnToPage($this->returnPage);
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT id, title, content, date_creation
                      FROM poeme
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
}
?>