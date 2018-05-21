<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>DevLog</h1>
<h5><a href="<?php echo ROOT_MNGT.'devlog/add'; ?>">Nouveau DevLog</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Titre français</th>
            <th style="width:15%;">Titre anglais</th>
            <th style="width:15%;">Projet associé</th>
            <th style="width:15%;">Date de création</th>
            <th style="width:15%;">Visible</td>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?php echo ROOT_MNGT.'devlog/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?php echo $item['id']; ?></td>
                    <td style="width:15%;"><?php echo $item['title_fr']; ?></td>
                    <td style="width:15%;"><?php echo $item['title_en']; ?></td>
                    <td style="width:15%;"><?php echo $item['project']; ?></td>
                    <td style="width:15%;"><?php echo $item['date_creation']; ?></td>
                    <td style="width:15%;"><?php echo $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
