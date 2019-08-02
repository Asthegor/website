<?php

class ConfigModel extends Model
{
    private $returnPage = 'configs';
    
    public function Index()
    {
        $this->query('SELECT id, data, value FROM config ORDER BY data');
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['data'] == '' || $post['value'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                //Insertion des données générales
                $this->query('INSERT INTO config (data, value) VALUES (:data, :value)');
                $this->bind(':data', strtoupper($post['data']));
                $this->bind(':value',$post['value']);
                $this->execute();
                //Verify
                $id = $this->lastIndexId();
                $this->close();
                if($id)
                {
                    $this->returnToPage($this->returnPage);
                }
                else
                {
                    Messages::setMsg('Error(s) during insert [$id='.$id.']', 'error');
                }
            }
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            if ($post['data'] == '' || $post['value'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                $this->startTransaction();
                //Insertion des données générales
                $this->query('UPDATE config SET data = :data, value = :value WHERE id = :id');
                $this->bind(':data', $post['data']);
                $this->bind(':value',$post['value']);
                $this->bind(':id',$post['id']);
                $resp = $this->execute();
                //Verify
                if($resp)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
                }
                $this->rollback();
                $this->close();
                Messages::setMsg('Error(s) during insert [$resp='.$resp.']', 'error');
            }
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT id, data, value FROM config WHERE id = :id');
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
            $this->query('DELETE FROM config WHERE id = :id');
            $this->bind(':id', $post['id']);
            $resp = $this->execute();
            if ($resp)
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

    public static function getConfig($data)
    {
        $model = new ConfigModel();
        $model->query("SELECT value FROM config WHERE data = :data");
        $model->bind(':data', $data);
        $rows = $model->single();
        return $rows['value'];
    }
}

?>