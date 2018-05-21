<?php

class DevLogModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  dl.id, dlfr.title title_fr, dlen.title title_en, dl.date_creation,
                              dl.bVisible, CONCAT(ptrfr.title, ' (', ptren.title, ')') project 
                      FROM devlog AS dl 
                        INNER JOIN devlog_tr AS dlfr ON dl.id = dlfr.id AND dlfr.id_Language = 1
                        INNER JOIN devlog_tr AS dlen ON dl.id = dlen.id AND dlen.id_Language = 2
                        INNER JOIN project_tr AS ptrfr ON dl.id_Project = ptrfr.id AND ptrfr.id_Language = 1
                        INNER JOIN project_tr AS ptren ON dl.id_Project = ptren.id AND ptren.id_Language = 2
                      ORDER BY dl.bVisible DESC, dl.date_creation DESC, dl.id DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['description_fr'] == '' || $post['description_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            // Insert into MySQL
            date_default_timezone_set('Europe/Paris');
            $this->changeDatabase(self::curDB);
            $this->startTransaction();
            //Insertion des données générales
            $this->query("INSERT INTO devlog (id_Project, date_creation, bVisible)
                          VALUES (:id_Project, :date_creation, :bVisible)");
            $this->bind(':id_Project', $post['project']);
            $this->bind(':date_creation', isset($post['date_creation']) && strtotime($post['date_creation']) ? $post['date_creation'] : date("Y-m-d"));
            $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
            $resp = $this->execute();
            $id = $this->lastIndexId();
            //Insertion du titre français
            $this->query('INSERT INTO devlog_tr (id, id_Language, title, description)
                          VALUES(:id, 1, :title, :description)');
            $this->bind(':id', $id);
            $this->bind(':title', $post['title_fr']);
            $this->bind(':description', $post['description_fr']);
            $respfr = $this->execute();
            //Insertion du titre anglais
            $this->query('INSERT INTO devlog_tr (id, id_Language, title, description)
                          VALUES(:id, 2, :title, :description)');
            $this->bind(':id', $id);
            $this->bind(':title', $post['title_en']);
            $this->bind(':description', $post['description_en']);
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
        return;
    }

    public function Update()
    {
        return;
    }

    public function Delete()
    {
        return;
    }
}

?>