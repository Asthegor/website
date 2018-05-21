<?php

class ProjectsModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  p.id, pfr.title title_fr, pen.title title_en, p.first_date_project,
                              p.bVisible, CONCAT(fe.name, ' (', l.name, ')') framework 
                      FROM project AS p 
                        INNER JOIN project_tr AS pfr ON p.id = pfr.id AND pfr.id_Language = 1
                        INNER JOIN project_tr AS pen ON p.id = pen.id AND pen.id_Language = 2
                        INNER JOIN frameworkengine AS fe ON p.id_FrameworkEngine = fe.id 
                        INNER JOIN proglanguage AS l ON fe.id_ProgLanguage = l.id 
                      ORDER BY p.bVisible DESC, p.first_date_project DESC, pfr.title, pen.title");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['destination'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            // Insert into MySQL
            $this->changeDatabase(self::curDB);
            $this->startTransaction();
            //Insertion des données générales
            $this->query('INSERT INTO project (id_FrameworkEngine, first_date_project, image, bVisible)
                          VALUES (:idframework, :dateproject, :image, :bVisible,)');
            $this->bind(':idframework', $post['framework']);
            $this->bind(':dateproject', $post['dateproject']);
            $this->bind(':image', $post['image']);
            $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
            $this->execute();
            $id = $this->lastIndexId();
            //Insertion du titre français
            $this->query('INSERT INTO project_tr (id, id_Language, title, description)
                          VALUES(:id, 1, :title, :description)');
            $this->bind(':id', $id);
            $this->bind(':title', $post['title_fr']);
            $this->bind(':description', $post['description_fr']);
            $this->execute();
            //Insertion du titre anglais
            $this->query('INSERT INTO project_tr (id, id_Language, title, description)
                          VALUES(:id, 2, :title, :description)');
            $this->bind(':id', $id);
            $this->bind(':title', $post['title_en']);
            $this->bind(':description', $post['description_en']);
            $this->execute();

            //Verify
            if($id)
            {
                $this->commit();
                $this->close();
                $this->returnToPage('content');
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
            if($post['title_fr'] == '' || $post['description_fr'] == '' || $post['title_en'] == '' || $post['description_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            $this->startTransaction();
            $this->query('UPDATE project 
                          SET id_FrameworkEngine = :framework, first_date_project = :first_date_project,
                          image = :image, bVisible = :bVisible
                          WHERE id = :id');
            $this->bind(':framework', $post['framework']);
            $this->bind(':first_date_project', isset($post['dateproject']) && strtotime($post['dateproject']) ? $post['dateproject'] : 'null');
            $this->bind(':image', isset($post['image']) ? $post['image'] : '');
            $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
            $this->bind(':id', $post['id']);
            $resp = $this->execute();

            // Mise à jour du titre FR
            $this->query('UPDATE project_tr 
                            SET title = :title, description = :description 
                            WHERE id = :id AND id_Language = 1');
            $this->bind(':title', $post['title_fr']);
            $this->bind(':description', $post['description_fr']);
            $this->bind(':id', $post['id']);
            $resfr = $this->execute();

            // Mise à jour du titre EN
            $this->query('UPDATE project_tr 
                            SET title = :title, description = :description 
                            WHERE id = :id AND id_Language = 2');
            $this->bind(':title', $post['title_en']);
            $this->bind(':description', $post['description_en']);
            $this->bind(':id', $post['id']);
            $resen = $this->execute();

            if($resp && $resfr && $resen)
            {
                $this->commit();
                $this->close();
                $this->returnToPage('frameworks');
            }
            $this->rollBack();
            $this->close();
            Messages::setMsg('Error(s) during update', 'error');
        }
        $this->query("SELECT p.id, p.first_date_project, p.id_FrameworkEngine, p.image, p.bVisible,
                             pfr.title title_fr, pfr.description description_fr,
                             pen.title title_en, pen.description description_en 
                      FROM project AS p 
                        INNER JOIN project_tr AS pfr ON p.id = pfr.id AND pfr.id_Language = 1
                        INNER JOIN project_tr AS pen ON p.id = pen.id AND pen.id_Language = 2
                      WHERE p.id = ".$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$_GET['id'].'" not found', 'error');
            $this->returnToPage('projects');
        }
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            //Mise à jour de la base
            $this->startTransaction();
            $this->query('DELETE FROM project WHERE id = :id');
            $this->bind(':id', $_GET['id']);
            $resp = $this->execute();
            $this->query('DELETE FROM project_tr WHERE id = :id');
            $this->bind(':id', $_GET['id']);
            $resptr = $this->execute();

            if($resp && $resptr)
            {
                $this->commit();
            }
            else
            {
                Messages::setMsg('Record "'.$_GET['id'].'" not deleted', 'error');
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage('projects');
        }
        $this->query("SELECT ptrfr.title title_fr, ptren.title title_en
                      FROM project AS p
                        INNER JOIN project_tr AS ptrfr ON p.id = ptrfr.id AND ptrfr.id_Language = 1
                        INNER JOIN project_tr AS ptren ON p.id = ptren.id AND ptren.id_Language = 2
                      WHERE p.id = ".$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$_GET['id'].'" not found', 'error');
            $this->returnToPage('frameworks');
        }
        return $rows;
    }
}

?>