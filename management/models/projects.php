<?php

class ProjectsModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  p.id, p.title, p.first_date_project, p.bVisible, 
                              CONCAT(fe.name, ' (', l.name, ')') framework 
                      FROM project AS p 
                        INNER JOIN frameworkengine AS fe ON p.id_FrameworkEngine = fe.id 
                        INNER JOIN proglanguage AS l ON fe.id_ProgLanguage = l.id 
                      ORDER BY p.bVisible DESC, p.first_date_project DESC, p.title");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['title'] == '' || $post['description_fr'] == '' || $post['description_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            $img_blob = '';
            $img_taille = 0;
            $img_type = '';
            $img_nom = '';
            $taillemax = 55000;
            if (isset($_FILES['projectimage']) && $_FILES['projectimage']['error'] != 4)
            {
                $ret = is_uploaded_file($_FILES['projectimage']['tmp_name']);
                if (!$ret)
                {
                    Messages::setMsg('Error during file transfert', 'error');
                    return;
                }
                $img_taille = $_FILES['projectimage']['size'];
                if ($img_taille > $taillemax)
                {
                    Messages::setMsg('File oversized', 'error');
                    return;
                }
                $img_type = $_FILES['projectimage']['type'];
                $img_nom  = $_FILES['projectimage']['name'];
                $img_blob = file_get_contents($_FILES['projectimage']['tmp_name']);
            }
            // Insert into MySQL
            date_default_timezone_set('Europe/Paris');
            $this->changeDatabase(self::curDB);
            $this->startTransaction();
            //Insertion des données générales
            $this->query("INSERT INTO project (id_FrameworkEngine, title, first_date_project, bVisible)
                          VALUES (:idframework, :title, :dateproject, :bVisible)");
            $this->bind(':idframework', $post['framework']);
            $this->bind(':title', $post['title']);
            $this->bind(':dateproject', isset($post['dateproject']) && strtotime($post['dateproject']) ? $post['dateproject'] : date("Y-m-d"));
            //$this->bind(':image', isset($post['image']) ? $post['image'] : 'null');
            $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
            $resp = $this->execute();
            $id = $this->lastIndexId();
            //Insertion du titre français
            $this->query('INSERT INTO project_tr (id, id_Language, description)
                          VALUES(:id, 1, :description)');
            $this->bind(':id', $id);
            $this->bind(':description', $post['description_fr']);
            $respfr = $this->execute();
            //Insertion du titre anglais
            $this->query('INSERT INTO project_tr (id, id_Language, description)
                          VALUES(:id, 2, :description)');
            $this->bind(':id', $id);
            $this->bind(':description', $post['description_en']);
            $respen = $this->execute();
            //Insertion de l'image
            $respi = 1;
            if ($img_blob != '')
            {
                $this->query("INSERT INTO projectimage (name, img_size, img_type, img_blob, id_Project)
                              VALUES (:name, :size, :type, :blob, :id_Project)");
                $this->bind(':id_Project', $id);
                $this->bind(':name', $img_nom);
                $this->bind(':size', $img_taille);
                $this->bind(':type', $img_type);
                $this->bind(':blob', base64_encode($img_blob));
                $respi = $this->execute();
            }

            //Verify
            if($resp && $respen && $respfr && $respi)
            {
                $this->commit();
                $this->close();
                $this->returnToPage('projects');
            }
            $this->rollback();
            $this->close();
            Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.', respi='.$respi.']', 'error');
        }
        return;
    }

    public function Update()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if($post['title'] == '' || $post['description_fr'] == '' || $post['description_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            $img_blob = '';
            $img_taille = 0;
            $img_type = '';
            $img_nom = '';
            $taillemax = 55000;
            if (isset($_FILES['projectimage']) && $_FILES['projectimage']['error'] != 4)
            {
                $ret = is_uploaded_file($_FILES['projectimage']['tmp_name']);
                if (!$ret)
                {
                    Messages::setMsg('Error during file transfert', 'error');
                    return;
                }
                $img_taille = $_FILES['projectimage']['size'];
                if ($img_taille > $taillemax)
                {
                    Messages::setMsg('File oversized', 'error');
                    return;
                }
                $img_type = $_FILES['projectimage']['type'];
                $img_nom  = $_FILES['projectimage']['name'];
                $img_blob = file_get_contents($_FILES['projectimage']['tmp_name']);
            }
            date_default_timezone_set('Europe/Paris');
            $this->startTransaction();
            $this->query('UPDATE project 
                          SET id_FrameworkEngine = :framework, first_date_project = :first_date_project,
                              title = :title, bVisible = :bVisible
                          WHERE id = :id');
            $this->bind(':framework', $post['framework']);
            $this->bind(':first_date_project', isset($post['dateproject']) && strtotime($post['dateproject']) ? $post['dateproject'] : 'null');
            $this->bind(':title', $post['title']);
            $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
            $this->bind(':id', $post['id']);
            $resp = $this->execute();
            // Mise à jour du titre FR
            $this->query('UPDATE project_tr 
                            SET description = :description 
                            WHERE id = :id AND id_Language = 1');
            $this->bind(':description', $post['description_fr']);
            $this->bind(':id', $post['id']);
            $resfr = $this->execute();
            // Mise à jour du titre EN
            $this->query('UPDATE project_tr 
                            SET description = :description 
                            WHERE id = :id AND id_Language = 2');
            $this->bind(':description', $post['description_en']);
            $this->bind(':id', $post['id']);
            $resen = $this->execute();
            //Insertion de l'image
            $respid = true;
            $respi = true;
            if ($img_blob != '')
            {
                $this->query("DELETE FROM projectimage WHERE id_Project = :id_Project");
                $this->bind(':id_Project', $post['id']);
                $respid = $this->execute();
                $this->query("INSERT INTO projectimage (name, img_size, img_type, img_blob, id_Project)
                              VALUES (:name, :size, :type, :blob, :id_Project)");
                $this->bind(':id_Project', $post['id']);
                $this->bind(':name', $img_nom);
                $this->bind(':size', $img_taille);
                $this->bind(':type', $img_type);
                $this->bind(':blob', base64_encode($img_blob));
                $respi = $this->execute();
            }

            //Verify
            if($resp && $resfr && $resen && $respid && $respi)
            {
                $this->commit();
                $this->close();
                $this->returnToPage('projects');
            }
            $this->rollBack();
            $this->close();
            Messages::setMsg('Error(s) during update', 'error');
        }
        $this->query("SELECT p.id, p.title, p.first_date_project, p.id_FrameworkEngine, p.bVisible,
                             pfr.description description_fr, pen.description description_en,
                             pi.name, pi.img_size, pi.img_type, pi.img_blob
                      FROM project AS p 
                        INNER JOIN project_tr AS pfr ON p.id = pfr.id AND pfr.id_Language = 1
                        INNER JOIN project_tr AS pen ON p.id = pen.id AND pen.id_Language = 2
                        LEFT JOIN projectimage AS pi ON p.id = pi.id_Project
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
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage('projects');
        }
        $this->query("SELECT title FROM project WHERE id = ".$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$_GET['id'].'" not found', 'error');
            $this->returnToPage('frameworks');
        }
        return $rows;
    }

    public function getImage($id)
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT name, img_size, img_type, img_blob
                      FROM projectimage
                      WHERE id_Project = ".$_GET['id']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function getList()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT id, title name FROM project");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}

?>