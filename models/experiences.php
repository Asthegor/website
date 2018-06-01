<?php

class ExperiencesModel extends Model
{
    const curDB = 'lacombed_experiences';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible,
                             efr.title title_fr, een.title title_en,
                             efr.content content_fr, een.content content_en,
                             CONCAT(cfr.name, ' (', ctfr.name, ')') city_fr,
                             CONCAT(cen.name, ' (', cten.name, ')') city_en,
                             cpy.name company
                      FROM experience AS e
                        INNER JOIN experience_tr AS efr ON e.id = efr.id AND efr.id_Language = 1
                        INNER JOIN experience_tr AS een ON e.id = een.id AND een.id_Language = 2
                        INNER JOIN city AS c ON e.id_City = c.id
                        INNER JOIN city_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN city_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                        INNER JOIN country AS ct ON c.id_Country = ct.id
                        INNER JOIN country_tr AS ctfr ON ct.id = ctfr.id AND ctfr.id_Language = 1
                        INNER JOIN country_tr AS cten ON ct.id = cten.id AND cten.id_Language = 2
                        INNER JOIN company AS cpy ON e.id_Company = cpy.id
                      WHERE e.bVisible = 1
                      ORDER BY e.bVisible DESC, e.date_start DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>