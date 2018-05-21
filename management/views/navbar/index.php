<h1>Barre de navigation</h1>
<h5><a href="<?php echo ROOT_MNGT.'navbar/add'; ?>">Nouvel item</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:15%;">Id</th>
            <th style="width:15%;">Titre français</th>
            <th style="width:15%;">Titre anglais</th>
            <th style="width:15%;">Destination</th>
            <th style="width:15%;">Ordre d'affichage</td>
            <th style="width:15%;">Visible</td>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?php echo ROOT_MNGT.'navbar/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:15%;"><?php echo $item['id']; ?></td>
                    <td style="width:15%;"><?php echo $item['title_fr']; ?></td>
                    <td style="width:15%;"><?php echo $item['title_en']; ?></td>
                    <td style="width:15%;"><?php echo $item['destination']; ?></td>
                    <td style="width:15%;"><?php echo $item['sortOrder']; ?></td>
                    <td style="width:15%;"><?php echo $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
