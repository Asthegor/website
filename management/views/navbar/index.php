<h1>Barre de navigation</h1>
<h5><a href="<?= ROOT_MNGT.'navbar/add'; ?>">Nouvel item</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align:left;">
        <tr>
            <th style="width:3%;">Id</th>
            <th style="width:15%;">Titre français</th>
            <th style="width:15%;">Titre anglais</th>
            <th style="width:30%;">Destination</th>
            <th style="width:10%;">Page</th>
            <th style="width:10%;">Ordre</th>
            <th style="width:10%;">Visible</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'navbar/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:3%;"><?= $item['id']; ?></td>
                    <td style="width:15%;"><?= $item['title_fr']; ?></td>
                    <td style="width:15%;"><?= $item['title_en']; ?></td>
                    <td style="width:30%;"><?= $item['destination']; ?></td>
                    <td style="width:10%;"><?= $item['bPage'] ? 'Oui' : 'Non'; ?></td>
                    <td style="width:10%;"><?= $item['sortOrder']; ?></td>
                    <td style="width:10%;"><?= $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>