<?php

class ConfigModel extends Model
{
    const curDB = "lacombed_config";

    public static function getConfig($data)
    {
        $model = new ConfigModel();
        $model->changeDatabase(self::curDB);
        $model->query("SELECT value FROM config WHERE data = :data");
        $model->bind(':data', $data);
        $rows = $model->single();
        return $rows['value'];
    }
}

?>