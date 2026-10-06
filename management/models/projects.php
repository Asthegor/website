<?php

class ProjectsModel extends Model
{
    private $returnPage = 'projects';
    private $targetDir = 'files/';
    
    public function Index()
    {
        $this->query("SELECT p.id, pfr.title title_fr, pen.title title_en, p.first_date_project, p.bVisible, 
                             fe.name framework, p.nbViews, p.file, p.zone, p.zone_order, p.image
                      FROM project AS p 
                        INNER JOIN project_tr AS pfr ON p.id = pfr.id AND pfr.id_Language = 1 
                        INNER JOIN project_tr AS pen ON p.id = pen.id AND pen.id_Language = 2 
                        INNER JOIN framework AS fe ON p.id_Framework = fe.id 
                        INNER JOIN proglanguage AS l ON fe.id_ProgLanguage = l.id 
                      ORDER BY p.zone, p.zone_order, p.bVisible DESC, p.first_date_project DESC");
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            if ($post['title_fr'] == '' || $post['desc_fr'] == '' || $post['zone'] == '')
            {
                error_log('[ADD] title_fr = ' . $post['title_fr'] . ', desc_fr = ' . $post['desc_fr'] . ', zone = ' . $post['zone']);
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            if (($post['num_version'] != '' && $post['date_version'] == '') || ($post['num_version'] == '' && $post['date_version'] != ''))
            {
                error_log('[ADD] num_version = ' . $post['num_version'] . ', date_version = ' . $post['date_version']);
                Messages::setMsg('If "Version number" is filled, "Version date" must be filled too (or vice versa).', 'error');
                return;
            }
            if ($post['date_version'] != '' && $post['date_version'] < $post['dateproject'])
            {
                error_log('[ADD] date_version = ' . $post['date_version'] . ', dateproject = ' . $post['dateproject']);
                Messages::setMsg("Date of version must be greater or equal than the project's date", 'error');
                return;
            }
            if (!isset($_POST['sections_fr']) || !isset($_POST['sections_en']) || empty($_POST['sections_fr']) || empty($_POST['sections_en'])) {
                error_log('[ADD] No sections found');
                Messages::setMsg('At least one section is mandatory.', 'error');
                return;
            }
            if (!$this->ValidateSections($_POST['sections_fr'] ?? [], $_POST['sections_en'] ?? [])) {
                error_log('[ADD] Sections invalid');
                // La méthode validateSections gère déjà le message d'erreur
                return;
            }
            if (intval($post['zone']) < 1 || intval($post['zone']) > 3)
            {
                error_log('[ADD] zone = ' . $post['zone']);
                Messages::setMsg('The "zone" value must be between 1 and 3 (included).', 'error');
                return;
            }
            $zoneOrder = 0;
            if (intval($post['zone']) > 1)
                $zoneOrder = $post['zone_order'];

            /*
            $img_blob = '';
            $img_taille = 0;
            $img_type = '';
            $img_nom = '';
            $taillemax = intval(ConfigModel::getConfig("MAX_FILE_SIZE"));
            if (isset($_FILES['projectimage']) && $_FILES['projectimage']['error'] != 4)
            {
                $img_taille = $_FILES['projectimage']['size'];
                $ret = is_uploaded_file($_FILES['projectimage']['tmp_name']);
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
                    $img_type = $_FILES['projectimage']['type'];
                    $img_nom  = $_FILES['projectimage']['name'];
                    $img_blob = file_get_contents($_FILES['projectimage']['tmp_name']);
                }
            }
            if (isset($_FILES["file"]))
            {
                $file = basename($_FILES["file"]["name"]);
                $target_file = ROOT_DIR. $this->targetDir . $file;
                $fileExtension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if($fileExtension != "" && $fileExtension !== "zip")
                {
                    Messages::setMsg("Error : file '".$file."' must have the extension 'zip'.", 'error');
                    return;
                }
            }
            else
                $file = "";
            */

            // Insert into MySQL
            date_default_timezone_set('Europe/Paris');
            $dateproject = isset($post['dateproject']) && strtotime($post['dateproject']) ? $post['dateproject'] : date("Y-m-d");
            $this->startTransaction();
            //Insertion des données générales
            $this->query("INSERT INTO project (id_Framework, zone, zone_order, first_date_project, bVisible, website, file, iframe, image)
                        VALUES (:idframework, :zone, :zoneorder, :dateproject, :bVisible, :website, :file, :iframe, :image)");
            $this->bind(':idframework', $post['framework'], PDO::PARAM_INT);
            $this->bind(':zone', $post['zone'], PDO::PARAM_INT);
            $this->bind(':zoneorder', $zoneOrder, PDO::PARAM_INT);
            $this->bind(':dateproject', $dateproject);
            $this->bind(':website', $post['website']);
            $this->bind(':file', isset($post['file']) ? $post['file'] : $post['old_file']);
            $this->bind(':iframe', $post['iframe']);
            $this->bind(':image', isset($post['image']) ? $post['image'] : $post['old_image']);
            $this->bind(':bVisible', (isset($post['bVisible']) ? $post['bVisible'] : 0), PDO::PARAM_INT);
            $resp = $this->execute();
            $id = $this->lastIndexId();

            //Insertion du titre français
            $title = $post['title_fr'];
            $shortdesc = $post['desc_fr'];
            $slug = $this->createSlug($title);
            var_dump($slug);
            $this->query('INSERT INTO project_tr (id, id_Language, title, short_desc, slug)
                        VALUES(:id, 1, :title, :short_desc, :slug)');
            $this->bind(':id', $id, PDO::PARAM_INT);
            $this->bind(':title', $title);
            $this->bind(':short_desc', $shortdesc);
            $this->bind(':slug', $slug);
            $respfr = $this->execute();

            //Insertion du titre anglais
            if ($post['title_en'] != "")
                $title = $post['title_en'];
            if ($post['desc_en'] != "")
                $shortdesc = $post['desc_en'];
            $slug = $this->createSlug($title);
            var_dump($slug);
            $this->query('INSERT INTO project_tr (id, id_Language, title, short_desc, slug)
                        VALUES(:id, 2, :title, :short_desc, :slug)');
            $this->bind(':id', $id, PDO::PARAM_INT);
            $this->bind(':title', $title);
            $this->bind(':short_desc', $shortdesc);
            $this->bind(':slug', $slug);
            $respen = $this->execute();

            //Insertion de la version
            $this->query('INSERT INTO version (id_Project, num_version, date_version)
                        VALUES(:id, :num_version, :date_version)');
            $this->bind(':id', $id, PDO::PARAM_INT);
            $this->bind(':num_version', isset($post['num_version']) ? $post['num_version'] : '0.0.1' );
            $this->bind(':date_version', isset($post['date_version']) ? $post['date_version'] : $dateproject );
            $respv = $this->execute();

            // Insertion des sections
            $resp_sections = $this->SaveProjectSections($id, $_POST['sections_fr'] ?? [], $_POST['sections_en'] ?? []);

            //Insertion de l'image
            $respi = true;
            /*
            if ($img_blob != '')
            {
                $this->query("INSERT INTO projectimage (name, img_size, img_type, img_blob, id_Project)
                            VALUES (:name, :size, :type, :blob, :id_Project)");
                $this->bind(':id_Project', $id, PDO::PARAM_INT);
                $this->bind(':name', $img_nom);
                $this->bind(':size', $img_taille);
                $this->bind(':type', $img_type);
                $this->bind(':blob', base64_encode($img_blob));
                $respi = $this->execute();
            }
            
            //Uplod file
            if ($file != "")
                $upload = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            else
            */
                $upload = true;

            //Verify
            if($resp && $respen && $respfr && $respi && $respv && $upload && $resp_sections)
            {
                $this->commit();
                $this->close();
                $this->returnToPage($this->returnPage);
                return;
            }
            $this->rollback();
            $this->close();
            Messages::setMsg('Error(s) during insert : [resp='.$resp.', respen='.$respen.', respfr='.$respfr.', respi='.$respi.', upload='.$upload.', resp_sections='.$resp_sections.']', 'error');
        }
        return;
    }

    public function Update()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            if ($post['title_fr'] == '' || $post['title_en'] == '' || $post['desc_fr'] == '' || $post['desc_en'] == '' || $post['zone'] == '')
            {
                Messages::setMsg('Please fill in all mandatory fields', 'error');
                return;
            }
            if (!$this->validateSections($post['sections_fr'] ?? [], $post['sections_en'] ?? []))
            {
                return;
            }
            if ($post['zone'] < 1 || $post['zone'] > 3)
            {
                Messages::setMsg('The "zone" value must be between 1 and 3 (included).', 'error');
                return;
            }
            $zoneorder = 0;
            if ($post['zone'] > 1)
                $zoneOrder = $post['zone_order'];
            
            /*
            $img_blob = '';
            $img_taille = 0;
            $img_type = '';
            $img_nom = '';

            $taillemax = intval(ConfigModel::getConfig("MAX_FILE_SIZE"));

            if (isset($_FILES['projectimage']) && $_FILES['projectimage']['error'] != 4)
            {
                $ret = is_uploaded_file($_FILES['projectimage']['tmp_name']);
                if (!$ret)
                {
                    Messages::setMsg('Error during file transfert', 'error');
                    return;
                }
                $img_taille = $_FILES['projectimage']['size'];
                if ($img_taille > $taillemax)
                {
                    Messages::setMsg('File oversized', 'error');
                    return;
                }
                $img_type = $_FILES['projectimage']['type'];
                $img_nom  = $_FILES['projectimage']['name'];
                $img_blob = file_get_contents($_FILES['projectimage']['tmp_name']);
            }
            */
            date_default_timezone_set('Europe/Paris');
            $this->startTransaction();
            $query = "UPDATE project " .
                     "SET id_Framework = :id_Framework, zone = :zone, zone_order = :zoneorder, first_date_project = :first_date_project, " .
                     "file=:file, image=:image, bVisible = :bVisible, website=:website, iframe=:iframe " .
                     "WHERE id = :id";
            $this->query($query);
            $this->bind(':id_Framework', $post['framework'], PDO::PARAM_INT);
            $this->bind(':zone', $post['zone'], PDO::PARAM_INT);
            $this->bind(':zoneorder', (isset($post['zone_order']) ? $post['zone_order'] : 0), PDO::PARAM_INT);
            $this->bind(':first_date_project', isset($post['dateproject']) && strtotime($post['dateproject']) ? $post['dateproject'] : 'null');
            $this->bind(':bVisible', (isset($post['bVisible']) ? $post['bVisible'] : 0), PDO::PARAM_INT);
            $this->bind(':website', $post['website']);
            $this->bind(':file', $post['file']);
            $this->bind(':image', $post['image']);
            $this->bind(':iframe', $post['iframe']);
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resp = $this->execute();
            
            $id = $post['id'];
            $resp_sections = $this->saveProjectSections($id, $post['sections_fr'] ?? [], $post['sections_en'] ?? []);
            
            // Mise à jour du titre FR
            $title = $post['title_fr'];
            $shortdesc = $post['desc_fr'];
            $this->query('UPDATE project_tr 
                            SET title = :title, short_desc = :short_desc, slug = :slug
                            WHERE id = :id AND id_Language = 1');
            $this->bind(':title', $title);
            $this->bind(':short_desc', $shortdesc);
            $this->bind(':slug', $this->createSlug($title));
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resfr = $this->execute();

            // Mise à jour du titre EN
            if ($post['title_en'] != "")
                $title = $post['title_en'];
            if ($post['desc_en'] != "")
                $shortdesc = $post['desc_en'];
            $this->query('UPDATE project_tr 
                            SET title = :title, short_desc = :short_desc, slug = :slug
                            WHERE id = :id AND id_Language = 2');
            $this->bind(':title', $title);
            $this->bind(':short_desc', $shortdesc);
            $this->bind(':slug', $this->createSlug($title));
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resen = $this->execute();

            //Insertion de la version si date plus récente
            $vm = new VersionModel();
            $version = $vm->getLastVersion($post['id']);
            if ($version['num_version'] != $post['num_version'] || $version['date_version'] != $post['date_version'])
            {
                $this->query('INSERT INTO version (id_Project, num_version, date_version)
                              VALUES(:id_project, :num_version, :date_version)');
                $this->bind(':id_project', $post['id'], PDO::PARAM_INT);
            }
            else
            {
                $this->query("UPDATE version SET num_version = :num_version, date_version = :date_version
                              WHERE id = :id");
                $this->bind(':id', $version['id'], PDO::PARAM_INT);
            }
            $this->bind(':num_version', $post['num_version']);
            $this->bind(':date_version', $post['date_version']);
            $respv = $this->execute();

            //Insertion de l'image
            $respid = true;
            $respi = true;
            /*
            if ($img_blob != '')
            {
                $this->query("DELETE FROM projectimage WHERE id_Project = :id_Project");
                $this->bind(':id_Project', $post['id'], PDO::PARAM_INT);
                $respid = $this->execute();
                $this->query("INSERT INTO projectimage (name, img_size, img_type, img_blob, id_Project)
                              VALUES (:name, :size, :type, :blob, :id_Project)");
                $this->bind(':id_Project', $post['id'], PDO::PARAM_INT);
                $this->bind(':name', $img_nom);
                $this->bind(':size', $img_taille);
                $this->bind(':type', $img_type);
                $this->bind(':blob', base64_encode($img_blob));
                $respi = $this->execute();
            }
            
            //Uplod file
            if ($file != "")
                $upload = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            else
            */
                $upload = true;

            //Verify
            if($resp && $resfr && $resen && $respid && $respi && $respv && $upload && $resp_sections)
            {
                $this->commit();
                $this->close();
                $this->returnToPage($this->returnPage);
                return;
            }
            $this->rollBack();
            $this->close();
            Messages::setMsg('Error(s) during update [resp='.$resp.', resfr='.$resfr.', resen='.$resen.', respid='.$respid.', respi='.$respi.', respv='.$respv.', upload='.$upload.', resp_sections='.$resp_sections.']', 'error');
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $rows = $this->getProjectDataForUpdate($get['id']);
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage($this->returnPage);
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
            $this->query('DELETE FROM project WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resp = $this->execute();
            $this->query('DELETE FROM project_tr WHERE id = :id');
            $this->bind(':id', $post['id'], PDO::PARAM_INT);
            $resptr = $this->execute();

            if($resp && $resptr)
            {
                $this->commit();
            }
            else
            {
                $this->rollBack();
            }
            $this->close();
            $this->returnToPage($this->returnPage);
        }
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query("SELECT p.id, pfr.title title_fr, pen.title title_en
                      FROM project AS p
                        INNER JOIN project_tr AS pfr ON p.id = pfr.id AND pfr.id_Language = 1
                        INNER JOIN project_tr AS pen ON p.id = pen.id AND pen.id_Language = 2
                      WHERE p.id = :id");
        $this->bind(':id', $get['id'], PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        if (!$rows)
        {
            Messages::setMsg('Record "'.$get['id'].'" not found', 'error');
            $this->returnToPage($this->returnPage);
            return;
        }
        return $rows;
    }

    public function getImage($id)
    {
        $this->query("SELECT name, img_size, img_type, img_blob
                      FROM projectimage
                      WHERE id_Project = :id");
        $this->bind(':id', $id, PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        return $rows;
    }

    public function getList($Order = "ASC")
    {
        $query = "SELECT p.id, pfr.title title_fr, pen.title title_en ".
                 "FROM project AS p ".
                    "INNER JOIN project_tr AS pfr ON p.id = pfr.id AND pfr.id_Language = 1 ".
                    "INNER JOIN project_tr AS pen ON p.id = pen.id AND pen.id_Language = 2 ".
                 "ORDER BY p.id ".$Order;
        $this->query($query);
        $rows = $this->resultSet();
        $this->close();
        return $rows;
    }

    public function getNbProjects($isActive = false)
    {
        $query = "SELECT COUNT(id) nb FROM project ";
        if($isActive)
        {
            $query .= " WHERE bVisible = 1";
        }
        $this->query($query);
        $rows = $this->single();
        $this->close();
        return $rows['nb'];
    }

    public function getNbActiveProjects() { return $this->getNbProjects(true); }

    public function getDateProject($id)
    {
        $this->query("SELECT first_date_project FROM project WHERE id = :id");
        $this->bind(':id', $id, PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        return $rows['first_date_project'];
    }
    private function validateSections(array $sections_fr, array $sections_en)
    {
        foreach ($sections_fr as $id => $fr_section)
        {
            if (empty(trim($fr_section['title'])) || empty(trim($fr_section['content'])))
            {
                Messages::setMsg('Le titre ou le contenu d\'une section française est vide.', 'error');
                return false;
            }
            if (!isset($sections_en[$id]))
            {
                Messages::setMsg("La contrepartie anglaise de la section ID {$id} est manquante (erreur interne).", 'error');
                return false;
            }
            $en_section = $sections_en[$id];
            if (empty(trim($en_section['title'])) || empty(trim($en_section['content'])))
            {
                Messages::setMsg("Le titre ou le contenu d'une section anglaise est vide (ID {$id}).", 'error');
                return false;
            }
        }
        return true;
    }
    private function saveProjectSections(int $projectId, array $sectionsFr, array $sectionsEn): bool
    {
        $success = true;
        
        // --- 1. NETTOYAGE : Suppression de toutes les anciennes sections ---
        $this->query('DELETE FROM projectsection_tr WHERE id_ProjectSection IN (SELECT id FROM projectsection WHERE id_Project = :id)');
        $this->bind(':id', $projectId, PDO::PARAM_INT);
        $success = $this->execute() && $success;
    
        $this->query('DELETE FROM projectsection WHERE id_Project = :id');
        $this->bind(':id', $projectId, PDO::PARAM_INT);
        $success = $this->execute() && $success;
    
        if (!$success) return false; // Arrêt immédiat si échec

        // --- 2. ENREGISTREMENT : Insérer les nouvelles sections par paires FR/EN ---
        $sectionOrder = 1;
    
        foreach ($sectionsFr as $uniqueId => $frData) {

            if (!isset($sectionsEn[$uniqueId])) continue; 

            $enData = $sectionsEn[$uniqueId];
    
            $this->query("INSERT INTO projectsection (id_Project, section_order) VALUES (:id_Project, :order)");
            $this->bind(':id_Project', $projectId, PDO::PARAM_INT);
            $this->bind(':order', $sectionOrder, PDO::PARAM_INT);
            $success = $this->execute() && $success;
            $newSectionId = $this->lastIndexId();
            
            if (!$success) return false; // Arrêt immédiat si échec
    
            $this->query("INSERT INTO projectsection_tr (id_ProjectSection, id_Language, title, content) VALUES (:id_ps, 1, :title_fr, :content_fr)");
            $this->bind(':id_ps', $newSectionId, PDO::PARAM_INT);
            $this->bind(':title_fr', $frData['title']);
            $this->bind(':content_fr', $frData['content']);
            $success = $this->execute() && $success;
            
            if (!$success) return false; // Arrêt immédiat si échec
    
            $this->query("INSERT INTO projectsection_tr (id_ProjectSection, id_Language, title, content) VALUES (:id_ps, 2, :title_en, :content_en)");
            $this->bind(':id_ps', $newSectionId, PDO::PARAM_INT);
            $this->bind(':title_en', $enData['title']);
            $this->bind(':content_en', $enData['content']);
            $success = $this->execute() && $success;
            
            if (!$success) return false; // Arrêt immédiat si échec
    
            $sectionOrder++; 
        }

        return $success; // Retourne l'état de réussite global
    }

    public function getProjectDataForUpdate($id)
    {
        // 1. Récupération des données principales du projet
        $this->query("SELECT p.id, p.first_date_project, p.id_Framework, p.zone, p.zone_order, p.bVisible,
                             pfr.title title_fr, pen.title title_en, p.website, p.iframe, p.image, 
                             pfr.short_desc desc_fr, pen.short_desc desc_en,
                             v.num_version, v.date_version, p.file
                      FROM project AS p 
                        INNER JOIN project_tr AS pfr ON p.id = pfr.id AND pfr.id_Language = 1
                        INNER JOIN project_tr AS pen ON p.id = pen.id AND pen.id_Language = 2
                        LEFT JOIN version AS v ON v.id = 
                            (SELECT max(vv.id) 
                             FROM version AS vv 
                             WHERE vv.id_Project = p.id 
                             ORDER BY vv.date_version DESC)
                      WHERE p.id = :id");
        $this->bind(':id', $id, PDO::PARAM_INT);
        $rows = $this->single();
        
        if (!$rows) return null;
    
        // 2. Récupération des sections
        $this->query("SELECT ps.id, pstr_fr.title title_fr, pstr_fr.content content_fr, 
                             pstr_en.title title_en, pstr_en.content content_en
                      FROM projectsection AS ps
                        INNER JOIN projectsection_tr AS pstr_fr ON ps.id = pstr_fr.id_ProjectSection AND pstr_fr.id_Language = 1
                        INNER JOIN projectsection_tr AS pstr_en ON ps.id = pstr_en.id_ProjectSection AND pstr_en.id_Language = 2
                      WHERE ps.id_Project = :id
                      ORDER BY ps.section_order ASC");
        $this->bind(':id', $id, PDO::PARAM_INT);
        $sections = $this->resultSet();
    
        $rows['sections_fr'] = [];
        $rows['sections_en'] = [];
        
        // Formatage des sections pour correspondre à la vue
        foreach ($sections as $section) {
            $rows['sections_fr'][] = [
                'id' => $section['id'],
                'title' => $section['title_fr'],
                'content' => $section['content_fr']
            ];
            $rows['sections_en'][] = [
                'id' => $section['id'],
                'title' => $section['title_en'],
                'content' => $section['content_en']
            ];
        }
        
        $this->close();
        return $rows;
    }
}
?>