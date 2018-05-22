<?php

class ProjectsModel extends Model
{
    const curDB = 'lacombed_projects';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  p.id, p.title, p.first_date_project, CONCAT(fe.name, ' (', l.name, ')') framework, pri.img_blob
                      FROM project AS p 
                        INNER JOIN frameworkengine AS fe ON p.id_FrameworkEngine = fe.id 
                        INNER JOIN proglanguage AS l ON fe.id_ProgLanguage = l.id 
                        LEFT JOIN projectimage AS pri ON pri.id_Project = p.id 
                      WHERE p.bVisible = 1
                      ORDER BY fe.sortOrder, p.first_date_project DESC, p.title");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>