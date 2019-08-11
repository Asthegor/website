<?php

class ConfigModel extends Model
{
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