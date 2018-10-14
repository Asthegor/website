<?php

class ProjectsModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  p.id, p.title, p.first_date_project, 
                              ptr.short_desc, CONCAT(fe.name, ' (', pl.name, ')') framework, pri.img_blob
                      FROM project AS p 
                        INNER JOIN frameworkengine AS fe ON p.id_FrameworkEngine = fe.id 
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