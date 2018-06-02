<?php

class NavBarModel extends Model
{
    const curDB = "lacombed_web";

    public function Index()
    {
        $this->changeDatabase(self::curDB);
        $this->query('SELECT i.id, i.bVisible, i.destination, i.sortOrder, 
                             itrfr.title title_fr, itren.title title_en
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itrfr ON i.id = itrfr.id AND itrfr.id_Language = 1
                        INNER JOIN indexitems_tr AS itren ON i.id = itren.id AND itren.id_Language = 2
                      WHERE i.id_Category = 1
                      ORDER BY i.bVisible DESC, i.sortOrder, i.id');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['destination'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->changeDatabase(self::curDB);
                $this->startTransaction();
                //Insertion des données générales
                $this->query('INSERT INTO indexitems (id_Category, destination, bVisible, sortOrder)
                            VALUES (1, :destination, :bVisible, :sortOrder)');
                $this->bind(':destination', $post['destination']);
                $this->bind(':bVisible', isset($post['bVisible']) ? $post['bVisible'] : 0);
                $this->bind(':sortOrder', $post['sortorder']);
                $this->execute();
                $id = $this->lastIndexId();
                //Insertion du titre français
                $this->query('INSERT INTO indexitems_tr (id, id_Language, title)
                            VALUES(:id, 1, :title)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_fr']);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('INSERT INTO indexitems_tr (id, id_Language, title)
                            VALUES(:id, 2, :title)');
                $this->bind(':id', $id);
                $this->bind(':title', $post['title_en']);
                $respen = $this->execute();

                //Verify
                if($id && $respfr && $respen)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('navbar');
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert [$id='.$id.', $respfr='.$respfr.', $respen='.$respen.']', 'error');
            }
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
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['destination'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                //Mise à jour de la base
                $this->startTransaction();
                // Mise à jour du titre FR
                $this->query('UPDATE indexitems_tr 
                              SET title = :title 
                              WHERE id = :id AND id_Language = 1');
                $this->bind(':title', $post['title_fr']);
                $this->bind(':id', $post['id']);
                $resfr = $this->execute();

                // Mise à jour du titre EN
                $this->query('UPDATE indexitems_tr 
                              SET title = :title 
                              WHERE id = :id AND id_Language = 2');
                $this->bind(':title', $post['title_en']);
                $this->bind(':id', $post['id']);
                $resen = $this->execute();

                // Mise à jour de la table indexitems
                $this->query('UPDATE indexitems 
                              SET destination=:destination, bVisible=:bVisible, sortOrder=:sortOrder 
                              WHERE id=:id');
                $this->bind(':destination', $post['destination']);
                $this->bind(':bVisible', $post['bVisible']);
                $this->bind(':sortOrder', $post['sortorder']);
                $this->bind(':id', $post['id']);
                $resii = $this->execute();

                if($resfr && $resen && $resii)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('navbar');
                }
                $this->rollBack();
                $this->close();
                Messages::setMsg('Error(s) during update', 'error');
            }
        }
        $this->query('SELECT i.id, i.bVisible, i.destination, i.sortOrder, 
                             itrfr.title title_fr, itren.title title_en
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itrfr ON i.id = itrfr.id AND itrfr.id_Language = 1
                        INNER JOIN indexitems_tr AS itren ON i.id = itren.id AND itren.id_Language = 2
                      WHERE i.id_Category = 1 AND i.id = :id');
        $this->bind(':id', $get['id']);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage('navbar');
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
            //Mise à jour de la base
            $this->startTransaction();
            $this->query('DELETE FROM indexitems WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resii = $this->execute();
            $this->query('DELETE FROM indexitems_tr WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resitr = $this->execute();

            if($resii && $resitr)
            {
                $this->commit();
            }
            else
            {
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage('navbar');
        }
        $this->query("SELECT i.id, itrfr.title title_fr, itren.title title_en
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itrfr ON i.id = itrfr.id AND itrfr.id_Language = 1
                        INNER JOIN indexitems_tr AS itren ON i.id = itren.id AND itren.id_Language = 2
                      WHERE i.id_Category = 1 AND i.id = :id");
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
}

?>