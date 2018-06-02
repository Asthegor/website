<?php

class CityModel extends Model
{
    const curDB = 'lacombed_experiences';

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT c.id, cfr.name title_fr, cen.name title_en, c.id_Country,
                             CONCAT(ctfr.name, ' (', cten.name, ')') country
                      FROM city AS c
                        INNER JOIN city_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN city_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                        INNER JOIN country AS ct ON c.id_Country = ct.id
                        INNER JOIN country_tr AS ctfr ON ct.id = ctfr.id AND ctfr.id_Language = 1
                        INNER JOIN country_tr AS cten ON ct.id = cten.id AND cten.id_Language = 2
                      ORDER BY cfr.name");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['name_fr'] == '' || $post['name_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->changeDatabase(self::curDB);
                $this->startTransaction();
                //Insertion des données générales
                $this->query("INSERT INTO city (id_Country)
                            VALUES (:id_Country)");
                $this->bind(':id_Country', $post['id_Country']);
                $resp = $this->execute();
                $id = $this->lastIndexId();

                // Insertion du nom français
                $this->query("INSERT INTO city_tr (id, name, id_Language) VALUES (:id, :name, 1)");
                $this->bind(':id', $id);
                $this->bind(':name', $post['name_fr']);
                $respfr = $this->execute();
                // insertion du nom anglais
                $this->query("INSERT INTO city_tr (id, name, id_Language) VALUES (:id, :name, 2)");
                $this->bind(':id', $id);
                $this->bind(':name', $post['name_en']);
                $respen = $this->execute();
                //Verify
                if($resp && $respfr && $respen)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('city');
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respfr='.$respfr.', respen='.$respen.']', 'error');
            }
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            $id = $post['id'];
            if ($post['name_fr'] == '' || $post['name_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->changeDatabase(self::curDB);
                $this->startTransaction();
                //Insertion des données générales
                $this->query('UPDATE city SET id_Country = :id_Country WHERE id = :id');
                $this->bind(':id', $id);
                $this->bind(':id_Country', $post['id_Country']);
                $resp = $this->execute();
                // Insertion du nom français
                $this->query("UPDATE city_tr SET name = :name WHERE id = :id AND id_Language = 1");
                $this->bind(':id', $id);
                $this->bind(':name', $post['name_fr']);
                $respfr = $this->execute();
                // insertion du nom anglais
                $this->query("UPDATE city_tr SET name = :name WHERE id = :id AND id_Language = 2");
                $this->bind(':id', $id);
                $this->bind(':name', $post['name_en']);
                $respen = $this->execute();
                //Verify
                if($resp && $respfr && $respen)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('city');
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert : [resp='.$resp.', respfr='.$respfr.', respen='.$respen.']', 'error');
            }
        }
        $this->changeDatabase(self::curDB);
        $this->query("SELECT c.id, cfr.name name_fr, cen.name name_en, c.id_Country
                      FROM city AS c
                        INNER JOIN city_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN city_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                      WHERE c.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage('city');
        }
        return $rows;
    }

    public function Delete()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if (isset($post['todelete']))
        {
            $this->query('DELETE FROM city WHERE id = :id');
            $this->bind(':id', $post['id']);
            $res = $this->execute();
            if (!$res)
            {
                Messages::setMsg('Record used by an experience.', 'error');
            }
            $this->close();
            $this->returnToPage('city');
        }
        $this->query("SELECT c.id, cfr.name name_fr, cen.name name_en,
                             CONCAT(ctfr.name, ' (', cten.name, ')') country
                      FROM city AS c
                        INNER JOIN city_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN city_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                        INNER JOIN country_tr AS ctfr ON c.id_Country = ctfr.id AND ctfr.id_Language = 1
                        INNER JOIN country_tr AS cten ON c.id_Country = cten.id AND cten.id_Language = 2
                      WHERE c.id = :id");
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage('frameworks');
        }
        return $rows;
    }

    public function getList()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT c.id, CONCAT(cfr.name, ' (', ctfr.name, ')') name
                      FROM city AS c
                        INNER JOIN city_tr AS cfr on c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN country_tr AS ctfr on c.id_Country = ctfr.id AND ctfr.id_Language = 1");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
}
?>