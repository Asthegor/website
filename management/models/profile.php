<?php

class ProfileModel extends Model
{
    private $returnPage = 'resume';
    public function Index()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            if ($post['content_fr'] == '' || $post['content_en'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
            }
            else
            {
                // Insert into MySQL
                date_default_timezone_set('Europe/Paris');
                $this->startTransaction();
                //Insertion du contenu français
                $content = $post['content_fr'];
                $this->query("UPDATE profile_tr
                            SET content = :content
                            WHERE id = :id AND id_Language = 1");
                $this->bind(':id', $post['id']);
                $this->bind(':content', $content);
                $respfr = $this->execute();
                //Insertion du titre anglais
                $content = $post['content_en'];
                $this->query("UPDATE profile_tr
                            SET content = :content
                            WHERE id = :id AND id_Language = 2");
                $this->bind(':id', $post['id']);
                $this->bind(':content', $content);
                $respen = $this->execute();
                
                //Verify
                if($respen && $respfr)
                {
                    $this->commit();
                    $this->close();
                    $this->returnToPage($this->returnPage);
                    return;
                }
                else
                {
                    $this->rollback();
                    $this->close();
                    Messages::setMsg('Error(s) during update : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.']', 'error');
                }
            }
        }
        $this->query("SELECT id, MAX(CASE WHEN id_Language = 1 THEN content END) AS content_fr, " .
                                "MAX(CASE WHEN id_Language = 2 THEN content END) AS content_en " .
                     "FROM profile_tr " .
                     "GROUP BY id");
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}
?>