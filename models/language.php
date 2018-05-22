<?php

class LanguageModel extends Model
{
    const curDB = "lacombed_web";

    public function getImage($codelanguage)
    {
        // Affichage du contenu
        $this->changeDatabase(self::curDB);
        $this->query("SELECT image FROM languages WHERE code = '".$codelanguage."'");
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}

?>