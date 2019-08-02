<?php

class OthersModel extends Model
{
    public function Index()
    {
        $this->query("SELECT i.destination, itr.title, itr.short_desc 
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itr ON i.id = itr.id
                        INNER JOIN language AS l ON itr.id_Language = l.id AND l.code = :codelanguage
                      WHERE i.id_Category = 1 AND i.bVisible = 1
                      AND i.bPage = 0 AND i.destination NOT LIKE 'mailto:%'
                      ORDER BY i.sortOrder");
        $this->bind(":codelanguage", $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>