<?php

class EducationModel extends Model
{
    const curDB = 'lacombed_experiences';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible,
                             efr.title title_fr, efr.description description_fr,
                             een.title title_en, een.description description_en,
                             efr.institution institution_fr, een.institution institution_en
                      FROM education AS e
                        INNER JOIN education_tr AS efr ON e.id = efr.id AND efr.id_Language = 1
                        INNER JOIN education_tr AS een ON e.id = een.id AND een.id_Language = 2
                      WHERE e.bVisible = 1
                      ORDER BY e.bVisible DESC, e.date_end, e.date_start DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>