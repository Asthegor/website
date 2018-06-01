<?php

class NavBarModel extends Model
{
    const curDB = "lacombed_web";

    public function getVisibleItems($language)
    {
        // Affichage du contenu
        if($language == null || $language == '') $language = 'FR';
        $this->changeDatabase(self::curDB);
        $this->query("SELECT i.destination, itr.title
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itr ON i.id = itr.id
                        INNER JOIN languages AS l ON itr.id_Language = l.id AND l.code = :language
                      WHERE i.id_Category = 1 AND i.bVisible = 1
                      ORDER BY i.sortOrder");
        $this->bind(':language', $language);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}

?>