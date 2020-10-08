<?php

class NavBarModel extends Model
{
    public function Index()
    {
        $this->query('SELECT i.id, i.bPage, i.bVisible, i.destination, 
                             i.sortOrder, i.bInNavBar,
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
                $img_blob = '';
                $img_taille = 0;
                $img_type = '';
                $img_nom = '';
                $taillemax = intval(ConfigModel::getConfig("MAX_FILE_SIZE"));
                if (isset($_FILES['itemimage']) && $_FILES['itemimage']['error'] != 4)
                {
                    $img_taille = $_FILES['itemimage']['size'];
                    $ret = is_uploaded_file($_FILES['itemimage']['tmp_name']);
                    if (!$ret)
                    {
                        Messages::setMsg('Error during file transfert', 'error');
                    }
                    else if ($img_taille > $taillemax)
                    {
                        Messages::setMsg('File oversized', 'error');
                    }
                    else
                    {
                        $img_type = $_FILES['itemimage']['type'];
                        $img_nom  = $_FILES['itemimage']['name'];
                        $img_blob = file_get_contents($_FILES['itemimage']['tmp_name']);
                    }
                }
                // Insert into MySQL
                $this->startTransaction();
                // Insertion de l'image
                $respi = true;
                $imgid = 0;
                if ($img_blob != '')
                {
                    $this->query("INSERT INTO images (name, img_size, img_type, img_blob)
                                VALUES (:name, :size, :type, :blob)");
                    $this->bind(':name', $img_nom);
                    $this->bind(':size', $img_taille);
                    $this->bind(':type', $img_type);
                    $this->bind(':blob', base64_encode($img_blob));
                    $respi = $this->execute();
                    $imgid = $this->lastIndexId();
                }
                //Insertion des données générales
                $this->query('INSERT INTO indexitems (id_Category, destination, bPage, 
                                                      bVisible, bInNavBar, sortOrder' .
                                                      ($imdid > 0 ? ', id_Image' : '') .')
                                VALUES (1, :destination, :bPage, :bVisible, :bInNavBar, :sortOrder' .
                                        ($imgid > 0 ? ',' . $imgid : '') . ')');
                $this->bind(':destination', $post['destination']);
                $this->bind(':bPage', (isset($post['bPage']) ? $post['bPage'] : 0), PDO::PARAM_INT);
                $this->bind(':bVisible', (isset($post['bVisible']) ? $post['bVisible'] : 0), PDO::PARAM_INT);
                $this->bind(':bInNavBar', (isset($post['bInNavBar']) ? $post['bInNavBar'] : 0), PDO::PARAM_INT);
                $this->bind(':sortOrder', $post['sortorder'], PDO::PARAM_INT);
                $this->execute();
                $id = $this->lastIndexId();
                //Insertion du titre français
                $this->query('INSERT INTO indexitems_tr (id, id_Language, title, short_desc)
                            VALUES(:id, 1, :title, :short_desc)');
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':title', $post['title_fr']);
                $this->bind(':short_desc', $post['short_desc_fr']);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $this->query('INSERT INTO indexitems_tr (id, id_Language, title)
                            VALUES(:id, 2, :title)');
                $this->bind(':id', $id, PDO::PARAM_INT);
                $this->bind(':title', $post['title_en']);
                $this->bind(':short_desc', $post['short_desc_en']);
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
                $img_blob = '';
                $img_taille = 0;
                $img_type = '';
                $img_nom = '';
    
                $taillemax = intval(ConfigModel::getConfig("MAX_FILE_SIZE"));
    
                if (isset($_FILES['itemimage']) && $_FILES['itemimage']['error'] != 4)
                {
                    $ret = is_uploaded_file($_FILES['itemimage']['tmp_name']);
                    if (!$ret)
                    {
                        Messages::setMsg('Error during file transfert', 'error');
                        return;
                    }
                    $img_taille = $_FILES['itemimage']['size'];
                    if ($img_taille > $taillemax)
                    {
                        Messages::setMsg('File oversized', 'error');
                        return;
                    }
                    $img_type = $_FILES['itemimage']['type'];
                    $img_nom  = $_FILES['itemimage']['name'];
                    $img_blob = file_get_contents($_FILES['itemimage']['tmp_name']);
                }
    
                //Mise à jour de la base
                $this->startTransaction();
                //Insertion de l'image
                $respi = true;
                $imgid = 0;
                if ($img_blob != '')
                {
                    $this->query("INSERT INTO images (name, img_size, img_type, img_blob)
                                VALUES (:name, :size, :type, :blob)");
                    $this->bind(':name', $img_nom);
                    $this->bind(':size', $img_taille);
                    $this->bind(':type', $img_type);
                    $this->bind(':blob', base64_encode($img_blob));
                    $respi = $this->execute();
                    $imgid = $this->lastIndexId();
                }
                // Mise à jour du titre FR
                $this->query('UPDATE indexitems_tr 
                              SET title = :title, short_desc = :short_desc 
                              WHERE id = :id AND id_Language = 1');
                $this->bind(':title', $post['title_fr']);
                $this->bind(':short_desc', $post['short_desc_fr']);
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $resfr = $this->execute();

                // Mise à jour du titre EN
                $this->query('UPDATE indexitems_tr 
                              SET title = :title, short_desc = :short_desc 
                              WHERE id = :id AND id_Language = 2');
                $this->bind(':title', $post['title_en']);
                $this->bind(':short_desc', $post['short_desc_en']);
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $resen = $this->execute();

                // Mise à jour de la table indexitems
                $this->query('UPDATE indexitems 
                              SET destination=:destination, bPage=:bPage,
                                  bVisible=:bVisible, sortOrder=:sortOrder,
                                  bInNavBar=:bInNavBar' .
                                  ($imgid > 0 ? ', id_Image='.$imgid : '') .
                              ' WHERE id=:id');
                $this->bind(':destination', $post['destination']);
                $this->bind(':bPage', $post['bPage']);
                $this->bind(':bVisible', $post['bVisible'], PDO::PARAM_INT);
                $this->bind(':bInNavBar', $post['bInNavBar'], PDO::PARAM_INT);
                $this->bind(':sortOrder', $post['sortorder'], PDO::PARAM_INT);
                $this->bind(':id', $post['id'], PDO::PARAM_INT);
                $resii = $this->execute();

                if($resfr && $resen && $resii && $respi)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage('navbar');
                }
                else
                {
                    $this->rollBack();
                    $this->close();
                    Messages::setMsg('Error(s) during update', 'error');
                    return;
                }
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT i.id, i.bPage, i.bVisible, i.destination, 
                             i.sortOrder, i.bInNavBar, 
                             itrfr.title title_fr, itrfr.short_desc short_desc_fr, 
                             itren.title title_en, itren.short_desc short_desc_en,
                             pi.name, pi.img_size, pi.img_type, pi.img_blob
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itrfr ON i.id = itrfr.id AND itrfr.id_Language = 1
                        INNER JOIN indexitems_tr AS itren ON i.id = itren.id AND itren.id_Language = 2
                        LEFT JOIN images AS pi ON i.id_Image = pi.id
                      WHERE i.id_Category = 1 AND i.id = :id');
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
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
            $this->returnToPage('navbar');
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
            $this->returnToPage('navbar');
        }
        return $rows;
    }
}
?>