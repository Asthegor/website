<?php

class ProjectModel extends Model
{
    public function Index()
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $query = "SELECT p.id, ptr.title, p.first_date_project, ptr.description, p.file, p.iframe, p.image, ".
                       " CONCAT(fe.name, ' (', pl.name, ')') AS framework, p.nbViews, p.website, ".
                       " pri.img_blob, CONCAT(v.num_version, ' (', v.date_version, ')') AS version, ".
                       " (SELECT count(pv.id) FROM project_views AS pv WHERE pv.id_Project = p.id) AS unique_views ".
                " FROM project AS p ".
                    " INNER JOIN framework AS fe ON p.id_Framework = fe.id ".
                    " INNER JOIN proglanguage AS pl ON fe.id_ProgLanguage = pl.id ".
                    " INNER JOIN project_tr AS ptr ON p.id = ptr.id ".
                    " INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage ".
                    " LEFT JOIN version AS v ON p.id = v.id_Project AND ".
                        " v.id = (SELECT max(vs.id) FROM version AS vs WHERE vs.id_Project = p.id) ".
                    " LEFT JOIN projectimage AS pri ON pri.id_Project = p.id ".
                " WHERE ptr.slug = :slug ".
                    " AND p.bVisible = 1";
        $this->query($query);
        $this->bind(':slug', $get['action']);
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->single();
        $this->close();
        
        $id = $rows['id'];
        $sections = $this->getProjectSections($id);
        $rows['sections'] = $sections;
        
        return $rows;

    }
    private function saveProjectViews($id)
    {
        $server = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
        // Retrieve nbViews for the project
        $this->query("SELECT IFNULL(nbViews, 0) AS nbViews FROM project WHERE id = :id");
        $this->bind(":id", $id);
        $nbViews = intval($this->single()['nbViews']);
        // Save the visitor ip to determine the number of unique views for the project
        $this->query("INSERT INTO project_views (ip, id_Project, last_time)
                      VALUES (:ip, :id_Project, now())
                      ON DUPLICATE KEY UPDATE
                        ip = :ip, 
                        id_Project = :id_Project, 
                        last_time = now()");
        $this->bind(":ip", $server["REMOTE_ADDR"]);
        $this->bind(":id_Project", $id);
        $this->execute();
        $this->close();
        // Update nbViews on the project
        $this->query("UPDATE project 
                      SET NbViews = :nb_views
                      WHERE id = :id");
        $this->bind(":nb_views", $nbViews + 1);
        $this->bind(":id", $id);
        $this->execute();
        $this->close();
    }
    
    public function GetPrevId($idProj)
    {
        $this->query("SELECT id FROM project WHERE bVisible = 1 ORDER BY first_date_project ASC");
        $rows = $this->resultSet();
        $this->close();

        $id = -1;
        foreach($rows as $row)
        {
            if ($row['id'] == $idProj)
                return $row['id'];
            if ($row['id'] <> $id)
                $id = $row['id'];
        }
        return $id;
    }

    public function GetNextId($idProj)
    {
        $this->query("SELECT id FROM project WHERE bVisible = 1 ORDER BY first_date_project DESC");
        $rows = $this->resultSet();
        $this->close();

        $id = -1;
        foreach($rows as $row)
        {
            if ($row['id'] == $idProj)
                return $row['id'];
            if ($row['id'] <> $id)
                $id = $row['id'];
        }
        return $id;
    }
    public function GetPrevSlug($slugProj)
    {
        $this->query("SELECT ptr.slug FROM project  AS p 
                  INNER JOIN project_tr AS ptr ON p.id = ptr.id 
                  INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage
                  WHERE p.bVisible = 1 ORDER BY p.first_date_project ASC");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();

        $slug = '';
        foreach($rows as $row)
        {
            if ($row['slug'] == $slugProj)
                break;
            if ($row['slug'] <> $slug)
                $slug = $row['slug'];
        }
        return $slug;
    }

    public function GetNextSlug($slugProj)
    {
        $this->query("SELECT ptr.slug FROM project  AS p 
                  INNER JOIN project_tr AS ptr ON p.id = ptr.id 
                  INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage
                  WHERE p.bVisible = 1 ORDER BY p.first_date_project DESC");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();

        $slug = '';
        foreach($rows as $row)
        {
            if ($row['slug'] == $slugProj)
                break;
            if ($row['slug'] <> $slug)
                $slug = $row['slug'];
        }
        return $slug;
    }
    
    public function IsIdValid($id)
    {
        $this->query("SELECT IFNULL(id, 0) AS valid FROM project WHERE id = :id AND bVisible = 1");
        $this->bind(":id", $id);
        $row = $this->single();
        return $row;
    }
    private function getProjectSections($id)
    {
        $query = "SELECT ps.id, pstr.title, pstr.content, ps.section_order
                  FROM projectsection AS ps
                  INNER JOIN projectsection_tr AS pstr ON ps.id = pstr.id_ProjectSection
                  INNER JOIN language AS l ON pstr.id_Language = l.id AND l.code = :codelanguage
                  WHERE ps.id_Project = :id
                  ORDER BY ps.section_order ASC";
        
        $this->query($query);
        $this->bind(':id', $id, PDO::PARAM_INT);
        $this->bind(':codelanguage', $_SESSION['language']);
        $sections = $this->resultSet();
        return $sections;
        
    }
    public function IsSlugValid($slug)
    {
        if (!isset($slug) || empty($slug))
            return false;

        $query = "SELECT 1 AS Valid 
                  FROM project AS p 
                  INNER JOIN project_tr AS ptr ON p.id = ptr.id 
                  INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage 
                  WHERE ptr.slug = :slug AND p.bVisible = 1";
        $this->query($query);
        $this->bind(':slug', $slug, PDO::PARAM_STR);
        $this->bind(':codelanguage', $_SESSION['language']);
        
        $rows = $this->single();
        return (isset($rows['Valid']) && $rows['Valid'] == "1");
    }
}

?>