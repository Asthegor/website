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
    public function getLabelIdByRef($ref)
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
        $label = $row['value'];
        $label = $this->createSlug($label);
        return $label;
    }
    protected function createSlug($text)
    {
        $text = strtolower(urldecode($text));
        $unwanted_array = [
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'ç' => 'c', 
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
            'ñ' => 'n', 
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 
            'ý' => 'y', 'ÿ' => 'y'
        ];
        $text = strtr($text, $unwanted_array);
        $text = str_replace(['-', ' ', '.', '(', ')', '%', '&'], '_', $text);
        $text = preg_replace('/[^a-z0-9_]/', '', $text);
        $text = preg_replace('/_+/', '_', $text);
        return trim($text, '_');
    }
}

?>