<?php

class ProjectsModel extends Model
{
    public function Index()
    {
        $this->query("SELECT p.id, ptr.title, p.first_date_project, p.nbViews, p.id_Framework, 
                             ptr.short_desc, CONCAT(fe.name, ' (', pl.name, ')') framework, pri.img_blob,
                             (SELECT count(pv.id) FROM project_views AS pv WHERE pv.id_Project = p.id) unique_views
                      FROM project AS p 
                        INNER JOIN framework AS fe ON p.id_Framework = fe.id 
                        INNER JOIN proglanguage AS pl ON fe.id_ProgLanguage = pl.id 
                        INNER JOIN project_tr as ptr ON p.id = ptr.id 
                        INNER JOIN language as l ON ptr.id_Language = l.id AND l.code = :codelanguage 
                        LEFT JOIN projectimage AS pri ON pri.id_Project = p.id 
                      WHERE p.bVisible = 1
                      ORDER BY p.first_date_project DESC");
        $this->bind(":codelanguage", $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>