<?php

class HomeModel extends Model
{
    const curDB = "lacombed_web";

    public function Index()
    {
        // Affichage du contenu
        $this->changeDatabase(self::curDB);
        $this->query('SELECT i.destination, itr.title, itr.short_desc 
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itr ON i.id = itr.id
                        INNER JOIN languages AS l ON itr.id_Language = l.id AND l.code = :codelanguage
                      WHERE i.id_Category = 2 AND i.bVisible = 1
                      ORDER BY i.sortOrder');
        $this->bind(":codelanguage", $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}

?>