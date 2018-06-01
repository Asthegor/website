<h1>Contenu de la page principale</h1>
<h5><a href="<?= ROOT_MNGT.'content/add'; ?>">Nouvel item</a></h5>
<br>
<div class="navbar-index">
    <table style="width:95%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
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
        <a href="<?= ROOT_MNGT.'content/update/'.$item['id']; ?>">
            <table style="width:95%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:15%;"><?= $item['title_fr']; ?></td>
                    <td style="width:15%;"><?= $item['title_en']; ?></td>
                    <td style="width:15%;"><?= $item['destination']; ?></td>
                    <td style="width:15%;"><?= $item['sortOrder']; ?></td>
                    <td style="width:15%;"><?= $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
