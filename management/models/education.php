<?php

class EducationModel extends Model
{
    private $returnPage = 'education';
    
    public function Index()
    {
        $this->query("SELECT ed.id, edfr.title title_fr, eden.title title_en, 
                             ed.date_start, ed.date_end, ed.bVisible
                      FROM education AS ed
                        INNER JOIN education_tr AS edfr ON ed.id = edfr.id AND edfr.id_Language = 1
                        INNER JOIN education_tr AS eden ON ed.id = eden.id AND eden.id_Language = 2
                      ORDER BY ed.bVisible DESC, ed.date_start DESC, ed.date_end");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if ($post['submit'])
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['description_fr'] == '' || $post['description_en'] == '')
            {
                $fields = '';
                if ($post['title_fr'] == '') { $fields .= 'title_fr, '; }
                if ($post['title_en'] == '') { $fields .= 'title_en, '; }
                if ($post['description_fr'] == '') { $fields .= 'description_fr, '; }
                if ($post['description_en'] == '') { $fields .= 'description_en, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->startTransaction();
                //Insertion des données générales
                $this->query("INSERT INTO education (date_start, date_end, link_diploma, bVisible)
                            VALUES (:date_start, :date_end, :link_diploma, :bVisible)");
                $this->bind(':date_start', $post['date_start']);
                $this->bind(':date_end', isset($post['date_end']) && $post['date_end'] > 0 ? $post['date_end'] : NULL);
                $this->bind(':link_diploma', $post['link_diploma']);
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $resp = $this->execute();
                $id = $this->lastIndexId();
                //Insertion du titre français
                $this->query('INSERT INTO education_tr (id, id_Language, title, description, institution)
                            VALUES(:id, 1, :title, :description, :institution)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':description', addslashes($post['description_fr']));
                $this->bind(':institution', addslashes($post['institution_fr']));
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('INSERT INTO education_tr (id, id_Language, title, description, institution)
                            VALUES(:id, 2, :title, :description, :institution)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_en']);
                $this->bind(':description', addslashes($post['description_en']));
                $this->bind(':institution', addslashes($post['institution_en']));
                $respen = $this->execute();
                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
            }
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if ($post['submit'])
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['description_fr'] == '' || $post['description_en'] == '')
            {
                $fields = '';
                if ($post['title_fr'] == '') { $fields .= 'title_fr, '; }
                if ($post['title_en'] == '') { $fields .= 'title_en, '; }
                if ($post['description_fr'] == '') { $fields .= 'description_fr, '; }
                if ($post['description_en'] == '') { $fields .= 'description_en, '; }
                $fields = substr($fields, 1, -2);
                Messages::setMsg('Please fill in all mandatory fields : '.$fields, 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->startTransaction();
                //Insertion des données générales
                $this->query("UPDATE education 
                            SET date_start = :date_start, date_end = :date_end,
                                link_diploma = :link_diploma, bVisible = :bVisible
                            WHERE id = :id");
                $this->bind(':date_start', $post['date_start']);
                $this->bind(':date_end', $post['date_end'] > 0 ? $post['date_end'] : NULL);
                $this->bind(':link_diploma', $post['link_diploma']);
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $this->bind(':id', $post['id']);
                $resp = $this->execute();
                //Insertion du titre français
                $this->query("UPDATE education_tr
                            SET title = :title, description = :description, institution = :institution
                            WHERE id = :id AND id_Language = 1");
                $this->bind(':id', $post['id']);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':description', $post['description_fr']);
                $this->bind(':institution', $post['institution_fr']);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query("UPDATE education_tr
                            SET title = :title, description = :description, institution = :institution
                            WHERE id = :id AND id_Language = 2");
                $this->bind(':id', $post['id']);
                $this->bind(':title', $post['title_en']);
                $this->bind(':description', $post['description_en']);
                $this->bind(':institution', $post['institution_en']);
                $respen = $this->execute();
                
                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                else
                {
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during update : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
                }
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT ed.id, ed.date_start, ed.date_end, ed.bVisible, ed.link_diploma,
                             edfr.title title_fr, edfr.description description_fr,
                             eden.title title_en, eden.description description_en,
                             edfr.institution institution_fr, eden.institution institution_en
                      FROM education AS ed
                        INNER JOIN education_tr AS edfr ON ed.id = edfr.id AND edfr.id_Language = 1
                        INNER JOIN education_tr AS eden ON ed.id = eden.id AND eden.id_Language = 2
                      WHERE ed.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function Delete()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->startTransaction();
            $this->query('DELETE FROM education WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resp = $this->execute();
            $this->query('DELETE FROM education_tr WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resptr = $this->execute();
            if ($resp && $resptr)
            {
                $this->commit();
            }
            else
            {
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage($this->returnPage);
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT ed.id, edfr.title title_fr, eden.title title_en
                      FROM education AS ed
                        INNER JOIN education_tr AS edfr ON ed.id = edfr.id AND edfr.id_Language = 1
                        INNER JOIN education_tr AS eden ON ed.id = eden.id AND eden.id_Language = 2
                      WHERE ed.id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage($this->returnPage);
        }
        return $rows;
    }
}
?>