<?php

class VersionModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $query = "SELECT v.id, p.title project, v.num_version, v.date_version
                  FROM version AS v INNER JOIN project AS p ON v.id_Project = p.id ".
                  (isset($_POST['projectid']) && is_numeric($_POST['projectid'])
                    ? " AND p.id = ".$_POST['projectid']
                    : "")
                ." ORDER BY p.title, v.date_version DESC";
        $this->query($query);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            date_default_timezone_set('Europe/Paris');
            $this->changeDatabase(self::curDB);
            $prjm = new ProjectsModel();
            $date_project = $prjm->getDateProject($post['id_Project']);
            if ($post['num_version'] == '' || $post['date_version'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else if (!strtotime($post['date_version']))
            {
                Messages::setMsg('Please fill a correct date', 'error');
            }
            else if (strtotime($post['date_version']) < strtotime($date_project))
            {
                Messages::setMsg('Date of version must be greater or equal than the project date', 'error');
            }
            else
            {
                //Insertion des données générales
                $this->startTransaction();
                $this->query("UPDATE version 
                            SET date_version = :date_version, num_version = :num_version 
                            WHERE id = :id");
                $this->bind(':date_version', $post['date_version']);
                $this->bind(':num_version', $post['num_version']);
                $this->bind(':id', $post['id']);
                $resp = $this->execute();
                //Verify
                if($resp)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('version');
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert', 'error');
            }
        }
        $this->changeDatabase(self::curDB);
        $this->query("SELECT v.id, p.title project, v.num_version, v.date_version, v.id_Project
                      FROM version AS v
                        INNER JOIN project AS p ON v.id_Project = p.id
                      WHERE v.id = ".$_GET['id']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->startTransaction();
            $this->query('DELETE FROM version WHERE id = :id');
            $this->bind(':id', $_GET['id']);
            $res = $this->execute();

            if ($res)
            {
                $this->commit();
            }
            else
            {
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage('version');
        }
        $this->query('SELECT num_version, date_version FROM version WHERE id = '.$_GET['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$_GET['id'].'" not found', 'error');
            $this->returnToPage('version');
        }
        return $rows;
    }

    public function getLastVersion($idproject)
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  id, id_Project, num_version, date_version
                      FROM version AS v
                      WHERE id_Project = :idproject
                      ORDER BY date_version DESC LIMIT 1");
        $this->bind(':idproject', $idproject);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
    public function getProjectList()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT DISTINCT p.id, p.title
                      FROM project AS p
                        INNER JOIN version AS v ON v.id_Project = p.id
                      ORDER BY p.title");
        $this->bind(':idproject', $idproject);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>