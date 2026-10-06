<?php

class IdentityModel extends Model
{
    public function Index()
    {
        $this->query("SELECT lastname, firstname FROM identity");
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}
?>