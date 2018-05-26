<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Versions</h1>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Projet associé</th>
            <th style="width:15%;">Numero de version</th>
            <th style="width:15%;">Date de la version</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?php echo ROOT_MNGT.'version/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?php echo $item['id']; ?></td>
                    <td style="width:15%;"><?php echo $item['project']; ?></td>
                    <td style="width:15%;"><?php echo $item['num_version']; ?></td>
                    <td style="width:15%;"><?php echo $item['date_version']; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
