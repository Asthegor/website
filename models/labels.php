<?php

class LabelsModel extends Model
{
    public function getLabelByRef($ref)
    {
        $this->query("SELECT ltr.value
                      FROM label AS lbl
                        INNER JOIN label_tr AS ltr ON lbl.id = ltr.id 
                        INNER JOIN language AS l ON ltr.id_Language = l.id AND l.code = :codelanguage
                      WHERE lbl.ref = :ref");
        $this->bind(':codelanguage', $_SESSION['language']);
        $this->bind(':ref', $ref);
        $row = $this->single();
        $this->close();
        return $row['value'];
    }
}

?>