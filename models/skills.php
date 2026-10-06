<?php

class SkillsModel extends Model
{
    public function Index()
    {
        $this->query("SELECT * FROM skills ORDER BY rank");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>