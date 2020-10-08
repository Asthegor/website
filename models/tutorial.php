<?php

class TutorialModel extends Model
{
    public function Display()
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT t.title, t.content, t.date_creation, t.date_update, t.id_Previous, t.id_Next
                      FROM tutorial AS t
                      WHERE t.id = :id");
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}

?>