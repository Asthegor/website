<?php

class EducationModel extends Model
{
    const curDB = 'lacombed_experiences';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible, e.link_diploma,
                             etr.title, etr.institution
                      FROM education AS e
                        INNER JOIN education_tr AS etr ON e.id = etr.id 
                        INNER JOIN language AS l on efr.id_Language = l.id AND l.code = :codelanguage
                      WHERE e.bVisible = 1
                      ORDER BY e.bVisible DESC, e.date_start DESC");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>