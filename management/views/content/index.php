<h1>Contenu de la page principale</h1>
<h5><a href="<?= ROOT_MNGT.'content/add'; ?>">Nouvel item</a></h5>
<br>
<div class="navbar-index">
    <table style="width:95%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:10%;">Titre français</th>
            <th style="width:10%;">Titre anglais</th>
            <th style="width:30%;">Destination</th>
            <th style="width:10%;">Ordre d'affichage</th>
            <th style="width:5%;">Visible</th>
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
                    <td style="width:10%;"><?= urldecode($item['title_fr']); ?></td>
                    <td style="width:10%;"><?= urldecode($item['title_en']); ?></td>
                    <td style="width:30%;"><?= urldecode($item['destination']); ?></td>
                    <td style="width:10%;"><?= $item['sortOrder']; ?></td>
                    <td style="width:5%;"><?= $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
