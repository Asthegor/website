<?php

class HomeModel extends Model
{
    public function Index()
    {
        $this->query('SELECT i.destination, itr.title, itr.short_desc 
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itr ON i.id = itr.id
                        INNER JOIN language AS l ON itr.id_Language = l.id AND l.code = :codelanguage
                      WHERE i.id_Category = 2 AND i.bVisible = 1
                      ORDER BY i.sortOrder');
        $this->bind(":codelanguage", $_SESSION['language']);
        $rows = $this->resultSet();
        return $rows;
    }
}

?>