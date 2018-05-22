<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Frameworks / Engins</h1>
<h5><a href="<?php echo ROOT_MNGT.'frameworks/add'; ?>">Nouveau framkework/engin</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Nom</th>
            <th style="width:15%;">Langage de programmation</th>
            <th style="width:15%;">Ordre d'affichage</th>
            <th style="width:15%;">Visible</td>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?php echo ROOT_MNGT.'frameworks/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?php echo $item['id']; ?></td>
                    <td style="width:15%;"><?php echo $item['name']; ?></td>
                    <td style="width:15%;"><?php echo $item['proglanguage']; ?></td>
                    <td style="width:15%;"><?php echo $item['sortOrder']; ?></td>
                    <td style="width:15%;"><?php echo $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
