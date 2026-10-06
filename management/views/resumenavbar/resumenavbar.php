<?php
  $fileName = basename($_SERVER['REQUEST_URI']);
?>
<table style="width: 100%;">
    <tr>
        <th style="width: 20%;"><a style="<?= $fileName == 'resume'  ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'resume'; ?>">Expériences</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'company' ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'company'; ?>">Société</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'city'    ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'city'; ?>">Ville</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'country' ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'country'; ?>">Pays</a></th>
        <th style="width: 20%;"><a style="<?= $fileName == 'cvs' ? 'color: #bba3c5' : 'color: white' ?>;" href="<?= ROOT_MNGT.'cvs'; ?>">CVs</a></th>
    </tr>
</table>