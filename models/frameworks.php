<?php

class FrameworksModel extends Model
{
    public function getAllFrameworks()
    {
        $this->query('SELECT fe.id, fe.name, fe.sortOrder, fe.bVisible, pl.name proglanguage
                      FROM framework AS fe
                        INNER JOIN proglanguage AS pl on fe.id_ProgLanguage = pl.id
                      ORDER BY fe.bVisible DESC, fe.sortOrder ASC');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}