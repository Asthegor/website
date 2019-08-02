<?php

class EducationModel extends Model
{
    public function Index()
    {
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible, e.link_diploma,
                             etr.title, etr.institution, etr.description
                      FROM education AS e
                        INNER JOIN education_tr AS etr ON e.id = etr.id 
                        INNER JOIN language AS l ON etr.id_Language = l.id AND l.code = :codelanguage
                      WHERE e.bVisible = 1
                      ORDER BY e.bVisible DESC, e.date_start DESC");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>