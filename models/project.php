<?php

class ProjectModel extends Model
{
    public function Display()
    {
        $this->saveProjectViews();
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT ptr.title, p.first_date_project, prev.id previous_id, next.id next_id, 
                             ptr.description, CONCAT(fe.name, ' (', pl.name, ')') framework, p.nbViews, p.website, 
                             pri.img_blob, CONCAT(v.num_version, ' (', v.date_version, ')') version,
                             (SELECT count(pv.id) FROM project_views AS pv WHERE pv.id_Project = p.id) unique_views
                      FROM project AS p
                        INNER JOIN framework AS fe ON p.id_Framework = fe.id
                        INNER JOIN proglanguage AS pl ON fe.id_ProgLanguage = pl.id
                        INNER JOIN project_tr AS ptr ON p.id = ptr.id 
                        INNER JOIN language AS l ON ptr.id_Language = l.id AND l.code = :codelanguage 
                        LEFT JOIN version AS v ON p.id = v.id_Project AND
                            v.id = (SELECT max(vs.id) FROM version AS vs WHERE vs.id_Project = p.id) 
                        LEFT JOIN projectimage AS pri ON pri.id_Project = p.id
                        LEFT JOIN project AS prev ON prev.id = 
                            (SELECT pp.id FROM project AS pp 
                             WHERE pp.first_date_project <= p.first_date_project AND pp.id <> p.id
                             ORDER BY pp.first_date_project DESC LIMIT 1)
                        LEFT JOIN project AS next ON next.id = 
                            (SELECT pn.id FROM project AS pn 
                             WHERE pn.first_date_project >= p.first_date_project AND pn.id <> p.id
                             ORDER BY pn.first_date_project LIMIT 1)
                      WHERE p.id = :id");
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
    private function saveProjectViews()
    {
        $server = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $id = $get['id'];
        // Retrieve nbViews for the project
        $this->query("SELECT nbViews FROM project WHERE id = :id");
        $this->bind(":id", $id);
        $nbViews = intval($this->single()['nbViews']);
        // Save the visitor ip to determine the number of unique views for the project
        $this->query("INSERT INTO project_views (ip, id_Project, last_time)
                      VALUES (:ip, :id_Project, now())
                      ON DUPLICATE KEY UPDATE
                        ip = :ip, 
                        id_Project = :id_Project, 
                        last_time = now()");
        $this->bind(":ip", $server["REMOTE_ADDR"]);
        $this->bind(":id_Project", $id);
        $this->execute();
        $this->close();
        // Update nbViews on the project
        $this->query("UPDATE project 
                      SET NbViews = :nb_views
                      WHERE id = :id");
        $this->bind(":nb_views", $nbViews + 1);
        $this->bind(":id", $id);
        $this->execute();
        $this->close();
    }

}

?>