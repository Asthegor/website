<?php

class TutorialsModel extends Model
{
    public function Index()
    {
        $this->query("SELECT t.id, t.title, t.short_desc, t.date_update, pl.name AS ProgLanguage
                      FROM tutorial AS t 
                        INNER JOIN proglanguage AS pl ON t.id_ProgLanguage = pl.id 
                      WHERE t.bVisible = 1");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}

?>