<?php

class ResumeModel extends Model
{
    private $returnPage = 'resume';
    
    public function Index()
    {
        $expTr = $this->generateLanguageQueryJoin('experience', 'e', 'experience_tr', 'title', false/*useTableSourceName*/, null/*fieldsNewNames*/);
        $cityTr = $this->generateLanguageQueryJoin('city', 'c', 'city_tr', 'name', true/*useTableSourceName*/, null/*fieldsNewNames*/);
        $countryTr = $this->generateLanguageQueryJoin('country', 'ct', 'country_tr', 'name', true/*useTableSourceName*/, null/*fieldsNewNames*/);
        // SELECT
        $query = "SELECT ";
        foreach($expTr['Fields'] as $field)
        {
            $query .= $field.',';
        }
        foreach($cityTr['Fields'] as $field)
        {
            $query .= $field.',';
        }
        foreach($countryTr['Fields'] as $field)
        {
            $query .= $field.',';
        }
        $query .= "e.id, e.date_start, e.date_end, e.bVisible, cpy.name company";
        
        // FROM
        $query .= " FROM experience AS e 
                   INNER JOIN company AS cpy ON e.id_Company = cpy.id
                   INNER JOIN city AS c ON e.id_City = c.id 
                   INNER JOIN country AS ct ON c.id_Country = ct.id ";
        foreach($expTr['Jointures'] as $jointure)
        {
            $query .= $jointure;
        }
        foreach($cityTr['Jointures'] as $jointure)
        {
            $query .= $jointure;
        }
        foreach($countryTr['Jointures'] as $jointure)
        {
            $query .= $jointure;
        }
        
        // WHERE
        $query .= " WHERE e.bVisible = 1
                      ORDER BY e.bVisible DESC, e.date_start DESC, e.date_end DESC";

        $this->query($query);
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
                $this->startTransaction();
                //Insertion des données générales
                $this->query("INSERT INTO experience (id_Company, id_City, date_start, date_end, bVisible)
                            VALUES (:id_Company, :id_City, :date_start, :date_end, :bVisible)");
                $this->bind(':id_Company', $post['id_Company'], PDO::PARAM_INT);
                $this->bind(':id_City', $post['id_City'], PDO::PARAM_INT);
                $this->bind(':date_start', $post['date_start']);
                $this->bind(':date_end', $post['date_end'] != '' ? $post['date_end'] : NULL);
                $this->bind(':bVisible', (isset($post['bVisible']) ? $post['bVisible'] : 0), PDO::PARAM_INT);
                $resp = $this->execute();
                $post['id'] = $this->lastIndexId();

                $resLang = $this->insertLanguageValues('experience_tr', $post);
                $res = array_count_values(array_filter($resLang))['1'] === count($resLang);
                //Verify
                if($resp && $res)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert', 'error');
            }
        }
        return;
    }

    public function Update()
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
                $this->startTransaction();
                $id = $post['id'];
                //Insertion des données générales
                $this->query("UPDATE experience SET id_Company = :id_Company, id_City = :id_City,
                                date_start = :date_start, date_end = :date_end, bVisible = :bVisible
                              WHERE id = :id");
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':id_Company', $post['id_Company'], PDO::PARAM_INT);
                $this->bind(':id_City', $post['id_City'], PDO::PARAM_INT);
                $this->bind(':date_start', $post['date_start']);
                $this->bind(':date_end', $post['date_end'] != '' ? $post['date_end'] : NULL);
                $this->bind(':bVisible', (isset($post['bVisible']) ? $post['bVisible'] : 0), PDO::PARAM_INT);
                $resp = $this->execute();
                //Insertion du titre français
                $this->query('UPDATE experience_tr
                              SET title = :title, content = :content
                              WHERE id = :id AND id_Language = 1');
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':content', $post['content_fr']);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('UPDATE experience_tr
                              SET title = :title, content = :content
                              WHERE id = :id AND id_Language = 2');
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':title', $post['title_en']);
                $this->bind(':content', $post['content_en']);
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
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT e.id, e.date_start, e.date_end, e.bVisible,
                             efr.title title_fr, efr.content content_fr,
                             een.title title_en, een.content content_en,
                             e.id_Company, e.id_City
                      FROM experience AS e
                        INNER JOIN experience_tr AS efr ON e.id = efr.id AND efr.id_Language = 1
                        INNER JOIN experience_tr AS een ON e.id = een.id AND een.id_Language = 2
                      WHERE e.id = :id");
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage($this->returnPage);
        }
        return $rows;
    }

    public function Delete()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            //Mise à jour de la base
            $this->startTransaction();
            $this->query('DELETE FROM experience WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resp = $this->execute();
            $this->query('DELETE FROM experience_tr WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
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
            $this->returnToPage($this->returnPage);
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT e.id, efr.title title_fr, een.title title_en
                      FROM experience AS e
                        INNER JOIN experience_tr AS efr ON e.id = efr.id AND efr.id_Language = 1
                        INNER JOIN experience_tr AS een ON e.id = een.id AND een.id_Language = 2
                      WHERE e.id = :id");
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
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