<?php

class ResumeModel extends Model
{
    const curDB = 'lacombed_experiences';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible,
                             efr.title title_fr, een.title title_en,
                             cfr.name city_fr, ctfr.name country_fr,
                             cen.name city_en, cten.name country_en,
                             cpy.name company
                      FROM experience AS e
                        INNER JOIN experience_tr AS efr ON e.id = efr.id AND efr.id_Language = 1
                        INNER JOIN experience_tr AS een ON e.id = een.id AND een.id_Language = 2
                        INNER JOIN city AS c ON e.id_City = c.id
                        INNER JOIN city_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN city_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                        INNER JOIN country AS ct ON c.id_Country = ct.id
                        INNER JOIN country_tr AS ctfr ON ct.id = ctfr.id AND ctfr.id_Language = 1
                        INNER JOIN country_tr AS cten ON ct.id = cten.id AND cten.id_Language = 2
                        INNER JOIN company AS cpy ON e.id_Company = cpy.id
                      WHERE e.bVisible = 1
                      ORDER BY e.bVisible DESC, e.date_start DESC, e.date_end DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if ($post['submit'])
        {
            date_default_timezone_set('Europe/Paris');
            if ($post['title_fr'] == '' || $post['title_en'] == '' 
             || $post['content_fr'] == '' || $post['content_en'] == ''
             || $post['date_start'] == '' || $post['id_Company'] == '' 
             || $post['id_City'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else if ($post['date_end'] != '' && strtotime($post['date_end']) <= strtotime($post['date_start']))
            {
                Messages::setMsg("End Date must be greater than the Start Date", 'error');
            }
            else
            {
                // Insert into MySQL
                $this->changeDatabase(self::curDB);
                $this->startTransaction();
                //Insertion des données générales
                $this->query("INSERT INTO experience (id_Company, id_City, date_start, date_end, bVisible)
                            VALUES (:id_Company, :id_City, :date_start, :date_end, :bVisible)");
                $this->bind(':id_Company', $post['id_Company']);
                $this->bind(':id_City', $post['id_City']);
                $this->bind(':date_start', $post['date_start']);
                $this->bind(':date_end', $post['date_end'] != '' ? $post['date_end'] : NULL);
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $resp = $this->execute();
                $id = $this->lastIndexId();
                //Insertion du titre français
                $this->query('INSERT INTO experience_tr (id, id_Language, title, content)
                            VALUES(:id, 1, :title, :content)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':content', $post['content_fr']);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('INSERT INTO experience_tr (id, id_Language, title, content)
                            VALUES(:id, 2, :title, :content)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_en']);
                $this->bind(':content', $post['content_en']);
                $respen = $this->execute();

                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('resume');
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
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if ($post['submit'])
        {
            date_default_timezone_set('Europe/Paris');
            if ($post['title_fr'] == '' || $post['title_en'] == '' 
             || $post['content_fr'] == '' || $post['content_en'] == ''
             || $post['date_start'] == '' || $post['id_Company'] == '' 
             || $post['id_City'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else if ($post['date_end'] != '' && strtotime($post['date_end']) <= strtotime($post['date_start']))
            {
                Messages::setMsg("End Date must be greater than the Start Date", 'error');
            }
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                $id = $post['id'];
                //Insertion des données générales
                $this->query("UPDATE experience SET id_Company = :id_Company, id_City = :id_City,
                                date_start = :date_start, date_end = :date_end, bVisible = :bVisible
                              WHERE id = :id");
                $this->bind(':id', $id);
                $this->bind(':id_Company', $post['id_Company']);
                $this->bind(':id_City', $post['id_City']);
                $this->bind(':date_start', $post['date_start']);
                $this->bind(':date_end', $post['date_end'] != '' ? $post['date_end'] : NULL);
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $resp = $this->execute();
                //Insertion du titre français
                $this->query('UPDATE experience_tr
                              SET title = :title, content = :content
                              WHERE id = :id AND id_Language = 1');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':content', $post['content_fr']);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('UPDATE experience_tr
                              SET title = :title, content = :content
                              WHERE id = :id AND id_Language = 2');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_en']);
                $this->bind(':content', $post['content_en']);
                $respen = $this->execute();

                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('resume');
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible,
                             efr.title title_fr, efr.content content_fr,
                             een.title title_en, een.content content_en,
                             e.id_Company, e.id_City
                      FROM experience AS e
                        INNER JOIN experience_tr AS efr ON e.id = efr.id AND efr.id_Language = 1
                        INNER JOIN experience_tr AS een ON e.id = een.id AND een.id_Language = 2
                      WHERE e.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage('resume');
        }
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            //Mise à jour de la base
            $this->startTransaction();
            $this->query('DELETE FROM experience WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resp = $this->execute();
            $this->query('DELETE FROM experience_tr WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resptr = $this->execute();

            if($resp && $resptr)
            {
                $this->commit();
            }
            else
            {
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage('resume');
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT e.id, efr.title title_fr, een.title title_en
                      FROM experience AS e
                        INNER JOIN experience_tr AS efr ON e.id = efr.id AND efr.id_Language = 1
                        INNER JOIN experience_tr AS een ON e.id = een.id AND een.id_Language = 2
                      WHERE e.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage('resume');
        }
        return $rows;
    }
}

?>