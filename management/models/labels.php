<?php

class LabelsModel extends Model
{
    private $returnPage = "configs";
    
    public function Index()
    {
        $this->query("SELECT id, ref FROM label ORDER BY id");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['submit']))
        {
            if ($post['ref'] == '')
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                //Insertion des données générales
                $this->query('INSERT INTO label (ref) VALUES (:ref)');
                $this->bind(':ref', strtolower($post['ref']));
                $resp = $this->execute();
                $id = $this->lastIndexId();
                //Insertion des données françaises
                $this->query('INSERT INTO label_tr (id, value, id_Language) VALUES(:id, :value, 1)');
                $this->bind(':id',$id);
                $this->bind(':value',$post['value_fr']);
                $respfr = $this->execute();
                // Insertion des données anglaises
                $this->query('INSERT INTO label_tr (id, value, id_Language) VALUES(:id, :value, 2)');
                $this->bind(':id',$id);
                $this->bind(':value',$post['value_en']);
                $respen = $this->execute();

                //Verify
                if($resp && $respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
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
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($post['submit']))
        {
            if ($post['ref'] == '' || $post['value_fr'] == '' || $post['value_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                //Insertion des données générales
                $this->query('UPDATE label SET ref = :ref WHERE id = :id');
                $this->bind(':ref', $post['ref']);
                $this->bind(':id',$post['id']);
                $resp = $this->execute();

                $this->query('UPDATE label_tr SET value = :value WHERE id = :id AND id_Language = 1');
                $this->bind(':value', $post['value_fr']);
                $this->bind(':id',$post['id']);
                $respfr = $this->execute();
                
                $this->query('UPDATE label_tr SET value = :value WHERE id = :id AND id_Language = 2');
                $this->bind(':value', $post['value_en']);
                $this->bind(':id',$post['id']);
                $respen = $this->execute();

                //Verify
                if($resp && $respfr && $respen)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert [$resp='.$resp.',respfr='.$respfr.',respen='.$respen.']', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT l.id, l.ref, len.value value_en, lfr.value value_fr '.
                     'FROM label AS l '.
                        'INNER JOIN label_tr AS lfr ON l.id = lfr.id AND lfr.id_Language = 1 '.
                        'INNER JOIN label_tr AS len ON l.id = len.id AND len.id_Language = 2 '.
                     'WHERE l.id = :id');
        $this->bind(':id',$get['id']);
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
            $this->query('DELETE FROM label WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resp = $this->execute();
            $this->query('DELETE FROM label_tr WHERE id = :id');
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
            return;
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT id, data, value FROM config WHERE id = :id');
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