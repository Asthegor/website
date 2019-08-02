<?php

class LanguageModel extends Model
{
    public function getImage($codelanguage)
    {
        $this->query("SELECT image FROM language WHERE code = :codelanguage");
        $this->bind(':codelanguage', $codelanguage);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}

?>