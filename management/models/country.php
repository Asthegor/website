<?php

class CountryModel extends Model
{
    const curDB = "lacombed_experiences";

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query('SELECT c.id, cfr.name name_fr, cen.name name_en
                      FROM country AS c
                        INNER JOIN country_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN country_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                      ORDER BY cfr.name');
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
                return;
            }
            // Insert into MySQL
            $this->changeDatabase(self::curDB);
            $this->startTransaction();
            $this->query("INSERT INTO country (id) VALUES (NULL)");
            $this->execute();
            $id = $this->lastIndexId();

            //Insertion du nom français
            $this->query('INSERT INTO country_tr (id, name, id_Language) VALUES (:id, :name, 1)');
            $this->bind(':id', $id);
            $this->bind(':name', $post['name_fr']);
            $resfr = $this->execute();
            //Insertion du nom anglais
            $this->query('INSERT INTO country_tr (id, name, id_Language) VALUES (:id, :name, 2)');
            $this->bind(':id', $id);
            $this->bind(':name', $post['name_en']);
            $resen = $this->execute();
            if($id && $resfr && $resen)
            {
                $this->commit();
                $this->close();
                $this->returnToPage('country');
                return;
            }
            $this->rollBack();
            $this->close();
            Messages::setMsg('Error(s) during insert [$resfr='.$resfr.', $resen='.$resen.']', 'error');
        }
        return;
    }

    public function Update()
    {
        $this->changeDatabase(self::curDB);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if (isset($post['submit']))
        {
            // Contrôle des données
            if ($post['name_fr'] == '' || $post['name_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                //Mise à jour de la base
                $this->startTransaction();
                $this->query('UPDATE country_tr SET name = :name WHERE id = :id AND id_Language = 1');
                $this->bind(':name', $post['name_fr']);
                $this->bind(':id', $post['id']);
                $resfr = $this->execute();
                $this->query('UPDATE country_tr SET name = :name WHERE id = :id AND id_Language = 2');
                $this->bind(':name', $post['name_en']);
                $this->bind(':id', $post['id']);
                $resen = $this->execute();
                if($resfr && $resen)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('country');
                    return;
                }
                $this->rollBack();
                $this->close();
                Messages::setMsg('Error(s) during update', 'error');
            }
        }
        $this->query('SELECT c.id, cfr.name name_fr, cen.name name_en
                      FROM country AS c
                        INNER JOIN country_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN country_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                      WHERE c.id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage('country');
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
            $this->query('DELETE FROM country WHERE id = :id');
            $this->bind(':id', $post['id']);
            $res = $this->execute();
            if (!$res)
            {
                Messages::setMsg('Record used by a city.', 'error');
            }
            $this->close();
            $this->returnToPage('country');
        }
        $this->query('SELECT c.id, cfr.name name_fr, cen.name name_en
                      FROM country AS c
                        INNER JOIN country_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN country_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                      WHERE c.id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            $this->returnToPage('country');
        }
        return $rows;
    }

    public function getList()
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT c.id, CONCAT(cfr.name, ' (', cen.name, ')') name
                      FROM country AS c
                        INNER JOIN country_tr AS cfr ON c.id = cfr.id AND cfr.id_Language = 1
                        INNER JOIN country_tr AS cen ON c.id = cen.id AND cen.id_Language = 2
                      ORDER BY name");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

}
?>