<?php

class VersionModel extends Model
{
    private $returnPage = 'version';
    
    public function Index()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $condition = "";
        if(isset($post['projectid']) && is_numeric($post['projectid']))
        {
            $condition .= " AND p.id = :id ";
        }
        $query = "SELECT v.id, v.num_version, v.date_version, v.id_Project, ptr.title project
                  FROM version AS v 
                    INNER JOIN project AS p ON v.id_Project = p.id ".$condition." 
                    INNER JOIN project_tr as ptr ON p.id = ptr.id
                      INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage
                  ORDER BY ptr.title, v.date_version DESC";
        $this->query($query);
        if (isset($post['projectid']) && is_numeric($post['projectid']))
        {
            $this->bind(':id', $post['projectid'], PDO::PARAM_INT);
        }
        $this->bind(':codelanguage', $_SESSION['language']);
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
                Messages::setMsg('Error(s) during insert', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT v.id, ptr.title project, v.num_version, v.date_version, v.id_Project
                      FROM version AS v
                        INNER JOIN project AS p ON v.id_Project = p.id
                        INNER JOIN project_tr as ptr ON p.id = ptr.id
                          INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage
                      WHERE v.id = :id");
        $this->bind(':codelanguage', $_SESSION['language']);
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function Delete()
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->startTransaction();
            $this->query('DELETE FROM version WHERE id = :id');
            $this->bind(':id', $get['id'], PDO::PARAM_INT);
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
            $this->returnToPage($this->returnPage);
        }
        $this->query('SELECT id, num_version, date_version FROM version WHERE id = :id');
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

    public function getLastVersion($idproject)
    {
        $this->query("SELECT  id, id_Project, num_version, date_version
                      FROM version AS v
                      WHERE id_Project = :idproject
                      ORDER BY date_version DESC LIMIT 1");
        $this->bind(':idproject', $idproject, PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
    public function getProjectList()
    {
        $this->query("SELECT DISTINCT p.id, ptr.title
                      FROM project AS p
                        INNER JOIN version AS v ON v.id_Project = p.id
                        INNER JOIN project_tr AS ptr ON p.id = ptr.id
                          INNER JOIN language AS l 
                            ON ptr.id_Language = l.id
                            AND l.code = :codelanguage 
                      ORDER BY ptr.title");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>