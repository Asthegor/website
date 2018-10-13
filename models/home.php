<?php

class HomeModel extends Model
{
    const curDB = "lacombed_web";

    public function Index()
    {
        // Affichage du contenu
        Profiling::StartChrono('ChangeDatabase');
        $this->changeDatabase(self::curDB);
        Profiling::EndChrono('ChangeDatabase');
        Profiling::StartChrono('LoadQuery');
        $this->query('SELECT i.destination, itrfr.title title_fr, itren.title title_en,itrfr.desc desc_fr, itren.desc desc_en
                      FROM indexitems AS i
                        INNER JOIN indexitems_tr AS itrfr ON i.id = itrfr.id AND itrfr.id_Language = 1
                        INNER JOIN indexitems_tr AS itren ON i.id = itren.id AND itren.id_Language = 2
                      WHERE i.id_Category = 2 AND i.bVisible = 1
                      ORDER BY i.sortOrder');
        Profiling::EndChrono('LoadQuery');
        Profiling::StartChrono('GetResults');
        $rows = $this->resultSet();
        Profiling::EndChrono('GetResults');
        Profiling::StartChrono('CloseQuery');
        $this->close();
        Profiling::EndChrono('CloseQuery');
        return $rows;
    }
}

?>