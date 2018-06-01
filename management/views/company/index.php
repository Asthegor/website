<?php
require_once('views/resumenavbar/resumenavbar.php');
?>
<h1>Sociétés</h1>
<h5><a href="<?= ROOT_MNGT.'company/add'; ?>">Nouvelle société</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Nom</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'company/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:15%;"><?= $item['name']; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
