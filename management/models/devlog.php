<?php

class DevLogModel extends Model
{
    private $returnPage = 'devlog';
    
    public function Index()
    {
        $this->query("SELECT  dl.id, dlfr.title title_fr, dlen.title title_en, dl.date_creation,
                              dl.bVisible, p.title project
                      FROM devlog AS dl 
                        INNER JOIN devlog_tr AS dlfr ON dl.id = dlfr.id AND dlfr.id_Language = 1
                        INNER JOIN devlog_tr AS dlen ON dl.id = dlen.id AND dlen.id_Language = 2
                        INNER JOIN project_tr AS p ON dl.id_Project = p.id and p.id_Language = 1
                      ORDER BY dl.bVisible DESC, dl.date_creation DESC, dl.id DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            if ($post['title_fr'] == '' || $post['description_fr'] == '')
            {
                $fields = '';
                if ($post['title_fr'] == '') { $fields .= 'title_fr, '; }
                if ($post['description_fr'] == '') { $fields .= 'description_fr, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
                return;
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->startTransaction();
                //Insertion des données générales
                $this->query("INSERT INTO devlog (id_Project, date_creation, session_time, bVisible)
                            VALUES (:id_Project, :date_creation, :session_time, :bVisible)");
                $this->bind(':id_Project', $post['id_Project']);
                $this->bind(':date_creation', isset($post['date_creation']) && strtotime($post['date_creation']) ? $post['date_creation'] : date("Y-m-d"));
                $this->bind(':session_time', isset($post['session_hours']) && isset($post['session_minutes']) ? date('H:i', mktime($post['session_hours'],$post['session_minutes'])) : date('H:i', mktime(0,0)));
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $resp = $this->execute();
                $id = $this->lastIndexId();
                //Insertion du titre français
                $title = $post['title_fr'];
                $description = $post['description_fr'];
                $this->query('INSERT INTO devlog_tr (id, id_Language, title, description)
                            VALUES(:id, 1, :title, :description)');
                $this->bind(':id', $id);
                $this->bind(':title', $title);
                $this->bind(':description', addslashes($description));
                $respfr = $this->execute();
                //Insertion du titre anglais
                if ($post['title_en'] != "")
                    $title = $post['title_en'];
                if ($post['description_en'] != "")
                    $description = $post['description_en'];
                $this->query('INSERT INTO devlog_tr (id, id_Language, title, description)
                            VALUES(:id, 2, :title, :description)');
                $this->bind(':id', $id);
                $this->bind(':title', $title);
                $this->bind(':description', addslashes($description));
                $respen = $this->execute();
                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        if ($get['action'] == 'add' && isset($get['id']) && $get['id'] > 0)
        {
            $this->query("SELECT p.id id_Project, pr.title project ".
                         "FROM project AS p ".
                            "INNER JOIN project_tr AS pr ON p.id = pr.id AND id_Language = 1". 
                         "WHERE p.id = :id");
            $this->bind(':id', $get['id']);
            $rows = $this->single();
            $this->close();
            return $rows;
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            if ($post['title_fr'] == '' || $post['description_fr'] == '')
            {
                $fields = '';
                if ($post['title_fr'] == '') { $fields .= 'title_fr, '; }
                if ($post['description_fr'] == '') { $fields .= 'description_fr, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->startTransaction();
                //Insertion des données générales
                $this->query("UPDATE devlog ".
                             "SET date_creation = :date_creation, bVisible = :bVisible, session_time=:session_time ".
                             "WHERE id = :id");
                $this->bind(':date_creation', isset($post['date_creation']) && strtotime($post['date_creation']) ? $post['date_creation'] : date("Y-m-d"));
                $this->bind(':session_time', isset($post['session_hours']) && isset($post['session_minutes']) ? date('H:i', mktime($post['session_hours'],$post['session_minutes'])) : date('H:i', mktime(0,0)));
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $this->bind(':id', $post['id']);
                $resp = $this->execute();
                //Insertion du titre français
                $title = $post['title_fr'];
                $description = $post['description_fr'];
                $this->query("UPDATE devlog_tr
                            SET title = :title, description = :description
                            WHERE id = :id AND id_Language = 1");
                $this->bind(':id', $post['id']);
                $this->bind(':title', $title);
                $this->bind(':description', addslashes($description));
                $respfr = $this->execute();
                //Insertion du titre anglais
                if ($post['title_en'] != "")
                    $title = $post['title_en'];
                if ($post['description_en'] != "")
                    $description = $post['description_en'];
                $this->query("UPDATE devlog_tr
                            SET title = :title, description = :description
                            WHERE id = :id AND id_Language = 2");
                $this->bind(':id', $post['id']);
                $this->bind(':title', $title);
                $this->bind(':description', addslashes($description));
                $respen = $this->execute();
                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        $this->query("SELECT dl.id, dl.id_Project, dl.date_creation, dl.date_creation, dl.bVisible, dl.session_time, 
                             dlfr.title title_fr, dlfr.description description_fr,
                             dlen.title title_en, dlen.description description_en,  ptr.title project
                      FROM devlog AS dl
                        INNER JOIN devlog_tr AS dlfr ON dl.id = dlfr.id AND dlfr.id_Language = 1
                        INNER JOIN devlog_tr AS dlen ON dl.id = dlen.id AND dlen.id_Language = 2
                        INNER JOIN project AS p ON dl.id_Project = p.id
                          INNER JOIN project_tr AS ptr ON p.id = ptr.id AND ptr.id_Language = 1
                      WHERE dl.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function Delete()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['todelete']))
        {
            $this->startTransaction();
            $this->query('DELETE FROM devlog WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resii = $this->execute();
            $this->query('DELETE FROM devlog_tr WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resitr = $this->execute();

            if ($resii && $resitr)
            {
                $this->commit();
            }
            else
            {
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage($this->returnPage);
            return;
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        $this->query('SELECT d.id, dlfr.title title_fr, dlen.title title_en
                      FROM devlog AS d
                        INNER JOIN devlog_tr AS dlfr ON d.id = dlfr.id AND dlfr.id_Language = 1
                        INNER JOIN devlog_tr AS dlen ON d.id = dlen.id AND dlen.id_Language = 2
                      WHERE d.id = :id');
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