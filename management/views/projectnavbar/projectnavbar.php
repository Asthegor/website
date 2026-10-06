<?php
  $fileName = basename($_SERVER['REQUEST_URI']);
?>
<table style="width: 100%;">
    <tr>
        <th style="width: 20%;"><a style="<?= $fileName == 'projects'     ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'projects'; ?>">Projets</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'devlog'       ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'devlog'; ?>">DevLog</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'version'      ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'version'; ?>">Version</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'frameworks'   ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'frameworks'; ?>">Framework/Engin</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'proglanguage' ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'proglanguage'; ?>">Langage de programmation</a></th>
    </tr>
</table>