<?php

function get_AllFrameworks($bdd)
{
  $query = "SELECT f.name as framework, f.id as frameworkid, l.name as language 
            FROM frameworkengine as f 
              INNER JOIN language as l ON f.id_Language = l.id
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
  $query = "SELECT * 
            FROM project
            WHERE bVisible = 1 AND id_FrameworkEngine = ?";
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
  $query = "SELECT p.*, f.name AS framework, l.name AS language 
            FROM project AS p 
              INNER JOIN frameworkengine AS f ON p.id_FrameworkEngine = f.id AND p.id = ?
              INNER JOIN language AS l ON f.id_Language = l.id
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
  $query = "SELECT f.name as framework, f.id as frameworkid, l.name as language 
            FROM frameworkengine as f 
              INNER JOIN language as l ON f.id_Language = l.id AND l.name = ?";
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