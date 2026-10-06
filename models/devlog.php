<?php

class DevlogModel extends Model
{
    public function Index()
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        $id = $get['id'];
        if($this->IsIdValid($id))
        {
            $this->query("SELECT d.id, d.date_creation, dtr.title, dtr.description, d.id_Project, ptr.title Project ".
                         "FROM devlog AS d ".
                            "INNER JOIN devlog_tr AS dtr ON d.id = dtr.id ".
                            "INNER JOIN language AS ld ON dtr.id_Language = ld.id AND ld.code = :codelanguage ".
                            "INNER JOIN project AS p ON d.id_Project = p.id ".
                            "INNER JOIN project_tr AS ptr ON p.id = ptr.id ".
                            "INNER JOIN language AS lp ON ptr.id_Language = lp.id AND lp.code = :codelanguage ".
                         "WHERE d.id = :id AND d.bVisible = 1 ".
                         "ORDER BY d.date_creation DESC, d.id DESC");
            $this->bind(":id", $id, PDO::PARAM_INT);
            $this->bind(':codelanguage', $_SESSION['language']);
            return $this->single();
        }
    }
    
    public function getAllDevlog()
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        $this->query("SELECT d.id, d.date_creation, dtr.title ".
                     "FROM devlog AS d ".
                        "INNER JOIN devlog_tr AS dtr ON d.id = dtr.id ".
                        "INNER JOIN language as l ON dtr.id_Language = l.id AND code = :codelanguage ".
                     "WHERE id_Project = :id_Project AND d.bVisible = 1 ".
                     "ORDER BY d.date_creation DESC, d.id DESC");
        $this->bind(":id_Project", $get['id'], PDO::PARAM_INT);
        $this->bind(':codelanguage', $_SESSION['language']);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }
    
    public function getSessionTime()
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        $this->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(session_time))) as SessionTime ".
                     "FROM devlog ".
                     "WHERE id_Project = :id_Project");
        $this->bind(":id_Project", $get['id'], PDO::PARAM_INT);
        return date("H:i", strtotime($this->single()['SessionTime']));
    }

    public function IsIdValid($id)
    {
        $this->query("SELECT IFNULL(id, 0) AS valid FROM devlog WHERE id = :id");
        $this->bind(":id", $id);
        $row = $this->single();
        return $row;
    }}

?>