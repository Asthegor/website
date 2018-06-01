<?php
require_once('views/resumenavbar/resumenavbar.php');
?>
<h1>Pays</h1>
<h5><a href="<?php echo ROOT_MNGT.'country/add'; ?>">Nouveau pays</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Nom français</th>
            <th style="width:15%;">Nom anglais</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?php echo ROOT_MNGT.'country/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?php echo $item['id']; ?></td>
                    <td style="width:15%;"><?php echo $item['name_fr']; ?></td>
                    <td style="width:15%;"><?php echo $item['name_en']; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
