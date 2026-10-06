<?php

class ProfileModel extends Model
{
    public function Index()
    {
        $this->query("SELECT ptr.content
                      FROM profile_tr AS ptr
                        INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage");
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}
?>