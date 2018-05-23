<?php

class VersionModel extends Model
{
    const curDB = 'lacombed_projects';

    public function getLastVersion($idproject)
    {
        $this->changeDatabase(self::curDB);
        $this->query("SELECT  id, id_Project, num_version, date_version
                      FROM version AS v
                      WHERE id_Project = :idproject
                      ORDER BY date_version DESC LIMIT 1");
        $this->bind(':idproject', $idproject);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}
?>