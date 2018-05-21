<?php

function get_AllFrameworks($bdd)
{
  $query = "SELECT f.name as framework, f.id as frameworkid, pl.name as proglanguage 
            FROM frameworkengine as f 
              INNER JOIN proglanguage as pl ON f.id_ProgLanguage = pl.id
            WHERE f.bVisible = 1";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result;
}

function get_ProjectsByFrameworkId($bdd, $frameworkid)
{
  $query = "SELECT p.*, ptrfr.title title_fr, ptren.title title_en, pri.img_blob image
            FROM project as p
              INNER JOIN project_tr AS ptrfr ON p.id = ptrfr.id AND ptrfr.id_Language = 1
              INNER JOIN project_tr AS ptren ON p.id = ptren.id AND ptren.id_Language = 2
              LEFT JOIN projectimage AS pri ON p.id = pri.id_Project
            WHERE p.bVisible = 1 AND p.id_FrameworkEngine = ?";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $frameworkid);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result;
}

function get_ProjectInfos($bdd, $projectid)
{
  $query = "SELECT p.*, f.name AS framework, pl.name AS proglanguage, ptrfr.title title_fr, pri.img_blob image,
                   ptren.title title_en, ptrfr.description description_fr, ptren.description description_en
            FROM project AS p 
              INNER JOIN project_tr AS ptrfr ON p.id = ptrfr.id AND ptrfr.id_Language = 1
              INNER JOIN project_tr AS ptren ON p.id = ptren.id AND ptren.id_Language = 2
              LEFT JOIN projectimage AS pri ON p.id = pri.id_Project
              INNER JOIN frameworkengine AS f ON p.id_FrameworkEngine = f.id AND p.id = ?
              INNER JOIN proglanguage AS pl ON f.id_ProgLanguage = pl.id
            WHERE p.bVisible = 1";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $projectid);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result->fetch_assoc();
}
function get_ProjectPreviousId($bdd, $projectid)
{
  $query = "SELECT id 
            FROM project 
            WHERE bVisible = 1 AND id < ?
            ORDER BY id DESC";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $projectid);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result->fetch_assoc();
}
function get_ProjectNextId($bdd, $projectid)
{
  $query = "SELECT id 
            FROM project 
            WHERE bVisible = 1 AND id > ?
            ORDER BY id";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $projectid);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result->fetch_assoc();
}

function get_LastProjectVersion($bdd, $projectid)
{
  $query = "SELECT v.* 
            FROM version AS v 
              INNER JOIN project AS p ON v.id_Project = p.id AND p.bVisible = 1 
            WHERE v.id_Project = ? 
            ORDER BY v.id DESC";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $projectid);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result->fetch_assoc();
}

function get_FrameworksByLanguage($bdd, $language)
{
  $query = "SELECT f.name as framework, f.id as frameworkid, l.name as proglanguage 
            FROM frameworkengine as f 
              INNER JOIN proglanguage as l ON f.id_ProgLanguage = l.id AND l.name = ?";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('s', $language);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result;
}

function get_FrameworksByLanguageId($bdd, $languageid)
{
  $query = "SELECT f.name as framework, f.id as frameworkid, l.name as language 
            FROM frameworkengine as f 
              INNER JOIN language as l ON f.id_Language = l.id AND l.id = ?";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $languageid);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result;
}
?>