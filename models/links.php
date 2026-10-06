<?php

class LinksModel extends Model
{
    public function Index()
    {
        $this->query("SELECT name, url FROM links");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>