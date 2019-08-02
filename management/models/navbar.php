<?php

class NavBarModel extends Model
{
    private $returnPage = 'navbar';
    
    public function Index()
    {
        $this->query('SELECT i.id, i.bPage, i.bVisible, i.destination, i.sortOrder, 
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
                $this->startTransaction();
                //Insertion des données générales
                $this->query('INSERT INTO indexitems (id_Category, destination, bPage, bVisible, sortOrder)
                            VALUES (1, :destination, :bPage, :bVisible, :sortOrder)');
                $this->bind(':destination', $post['destination']);
                $this->bind(':bPage', (isset($post['bPage']) ? $post['bPage'] : 0), PDO::PARAM_INT);
                $this->bind(':bVisible', (isset($post['bVisible']) ? $post['bVisible'] : 0), PDO::PARAM_INT);
                $this->bind(':sortOrder', $post['sortorder'], PDO::PARAM_INT);
                $this->execute();
                $id = $this->lastIndexId();
                //Insertion du titre français
                $this->query('INSERT INTO indexitems_tr (id, id_Language, title)
                            VALUES(:id, 1, :title)');
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':title', $post['title_fr']);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('INSERT INTO indexitems_tr (id, id_Language, title)
                            VALUES(:id, 2, :title)');
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':title', $post['title_en']);
                $respen = $this->execute();

                //Verify
                if($id && $respfr && $respen)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
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
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
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
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $resfr = $this->execute();

                // Mise à jour du titre EN
                $this->query('UPDATE indexitems_tr 
                              SET title = :title 
                              WHERE id = :id AND id_Language = 2');
                $this->bind(':title', $post['title_en']);
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $resen = $this->execute();

                // Mise à jour de la table indexitems
                $this->query('UPDATE indexitems 
                              SET destination=:destination, bPage=:bPage, bVisible=:bVisible, sortOrder=:sortOrder 
                              WHERE id=:id');
                $this->bind(':destination', $post['destination']);
                $this->bind(':bPage', $post['bPage'], PDO::PARAM_INT);
                $this->bind(':bVisible', $post['bVisible'], PDO::PARAM_INT);
                $this->bind(':sortOrder', $post['sortorder'], PDO::PARAM_INT);
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $resii = $this->execute();

                if($resfr && $resen && $resii)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                }
                $this->rollBack();
                $this->close();
                Messages::setMsg('Error(s) during update', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT i.id, i.bPage, i.bVisible, i.destination, i.sortOrder, 
                             itrfr.title title_fr, itren.title title_en
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itrfr ON i.id = itrfr.id AND itrfr.id_Language = 1
                        INNER JOIN indexitems_tr AS itren ON i.id = itren.id AND itren.id_Language = 2
                      WHERE i.id_Category = 1 AND i.id = :id');
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
            $this->query('DELETE FROM indexitems WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resii = $this->execute();
            $this->query('DELETE FROM indexitems_tr WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
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
            $this->returnToPage($this->returnPage);
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT i.id, itrfr.title title_fr, itren.title title_en
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itrfr ON i.id = itrfr.id AND itrfr.id_Language = 1
                        INNER JOIN indexitems_tr AS itren ON i.id = itren.id AND itren.id_Language = 2
                      WHERE i.id_Category = 1 AND i.id = :id");
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