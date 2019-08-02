<?php

class ExperiencesModel extends Model
{
    public function Index()
    {
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible, etr.title, etr.content, 
                             CONCAT(ctr.name, ' (', cttr.name, ')') city, cpy.name company
                      FROM experience AS e
                        INNER JOIN experience_tr AS etr ON e.id = etr.id 
                        INNER JOIN language AS etrl 
                            ON etr.id_Language = etrl.id AND etrl.code = :codelanguage
                        INNER JOIN city AS c ON e.id_City = c.id
                        INNER JOIN city_tr AS ctr ON c.id = ctr.id 
                        INNER JOIN language AS ctrl 
                            ON ctr.id_Language = ctrl.id AND ctrl.code = :codelanguage
                        INNER JOIN country AS ct ON c.id_Country = ct.id
                        INNER JOIN country_tr AS cttr ON ct.id = cttr.id 
                        INNER JOIN language AS cttrl 
                            ON cttr.id_Language = cttrl.id AND cttrl.code = :codelanguage
                        INNER JOIN company AS cpy ON e.id_Company = cpy.id
                      WHERE e.bVisible = 1
                      ORDER BY e.bVisible DESC, e.date_start DESC");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>