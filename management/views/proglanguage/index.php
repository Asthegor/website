<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Langages de programmation</h1>
<h5><a href="<?php echo ROOT_MNGT.'proglanguage/add'; ?>">Nouveau language</a></h5>
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
        <a href="<?php echo ROOT_MNGT.'proglanguage/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?php echo $item['id']; ?></td>
                    <td style="width:15%;"><?php echo $item['name']; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
