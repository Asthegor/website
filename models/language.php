<?php

class LanguageModel extends Model
{
    public function getImage()
    {
        $this->query("SELECT image FROM language WHERE code = :codelanguage");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}

?>