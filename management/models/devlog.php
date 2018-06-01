<?php

class DevLogModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  dl.id, dlfr.title title_fr, dlen.title title_en, dl.date_creation,
                              dl.bVisible, p.title project
                      FROM devlog AS dl 
                        INNER JOIN devlog_tr AS dlfr ON dl.id = dlfr.id AND dlfr.id_Language = 1
                        INNER JOIN devlog_tr AS dlen ON dl.id = dlen.id AND dlen.id_Language = 2
                        INNER JOIN project AS p ON dl.id_Project = p.id
                      ORDER BY dl.bVisible DESC, dl.date_creation DESC, dl.id DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['description_fr'] == '' || $post['description_en'] == '')
            {
                $fields = '';
                if ($post['title_fr'] == '') { $fields .= 'title_fr, '; }
                if ($post['title_en'] == '') { $fields .= 'title_en, '; }
                if ($post['description_fr'] == '') { $fields .= 'description_fr, '; }
                if ($post['description_en'] == '') { $fields .= 'description_en, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->changeDatabase(self::curDB);
                $this->startTransaction();
                //Insertion des données générales
                $this->query("INSERT INTO devlog (id_Project, date_creation, bVisible)
                            VALUES (:id_Project, :date_creation, :bVisible)");
                $this->bind(':id_Project', $post['id_Project']);
                $this->bind(':date_creation', isset($post['date_creation']) && strtotime($post['date_creation']) ? $post['date_creation'] : date("Y-m-d"));
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $resp = $this->execute();
                $id = $this->lastIndexId();
                //Insertion du titre français
                $this->query('INSERT INTO devlog_tr (id, id_Language, title, description)
                            VALUES(:id, 1, :title, :description)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':description', addslashes($post['description_fr']));
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('INSERT INTO devlog_tr (id, id_Language, title, description)
                            VALUES(:id, 2, :title, :description)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_en']);
                $this->bind(':description', addslashes($post['description_en']));
                $respen = $this->execute();
                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('devlog');
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
            }
        }
        if ($get['action'] == 'add' && isset($get['id']))
        {
            $this->changeDatabase(self::curDB);
            $this->query("SELECT id id_Project, title project FROM project WHERE id = :id");
            $this->bind(':id', $get['id']);
            $rows = $this->single();
            $this->close();
            return $rows;
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['description_fr'] == '' || $post['description_en'] == '')
            {
                $fields = '';
                if ($post['title_fr'] == '') { $fields .= 'title_fr, '; }
                if ($post['title_en'] == '') { $fields .= 'title_en, '; }
                if ($post['description_fr'] == '') { $fields .= 'description_fr, '; }
                if ($post['description_en'] == '') { $fields .= 'description_en, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->changeDatabase(self::curDB);
                $this->startTransaction();
                //Insertion des données générales
                $this->query("UPDATE devlog 
                            SET date_creation = :date_creation, bVisible = :bVisible 
                            WHERE id = :id");
                $this->bind(':date_creation', isset($post['date_creation']) && strtotime($post['date_creation']) ? $post['date_creation'] : date("Y-m-d"));
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $this->bind(':id', $post['id']);
                $resp = $this->execute();
                //Insertion du titre français
                $this->query("UPDATE devlog_tr
                            SET title = :title, description = :description
                            WHERE id = :id AND id_Language = 1");
                $this->bind(':id', $post['id']);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':description', addslashes($post['description_fr']));
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query("UPDATE devlog_tr
                            SET title = :title, description = :description
                            WHERE id = :id AND id_Language = 2");
                $this->bind(':id', $post['id']);
                $this->bind(':title', $post['title_en']);
                $this->bind(':description', addslashes($post['description_en']));
                $respen = $this->execute();
                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('devlog');
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
            }
        }
        $this->changeDatabase(self::curDB);
        $this->query("SELECT dl.id, dl.id_Project, dl.date_creation, dl.date_creation, dl.bVisible,
                             dlfr.title title_fr, dlfr.description description_fr,
                             dlen.title title_en, dlen.description description_en,  p.title project
                      FROM devlog AS dl
                        INNER JOIN devlog_tr AS dlfr ON dl.id = dlfr.id AND dlfr.id_Language = 1
                        INNER JOIN devlog_tr AS dlen ON dl.id = dlen.id AND dlen.id_Language = 2
                        INNER JOIN project AS p ON dl.id_Project = p.id
                      WHERE dl.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
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
            $this->returnToPage('devlog');
        }
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
            $this->returnToPage('devlog');
        }
        return $rows;
    }
}
?>