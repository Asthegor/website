<h1>Education / Certifications</h1>
<h5><a href="<?= ROOT_MNGT.'education/add'; ?>">Nouveau diplôme/Nouvelle certification</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Nom français</th>
            <th style="width:15%;">Nom anglais</th>
            <th style="width:15%;">Date de début</th>
            <th style="width:15%;">Date de fin</th>
            <th style="width:10%;">Visible</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'education/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:15%;"><?= urldecode($item['title_fr']); ?></td>
                    <td style="width:15%;"><?= urldecode($item['title_en']); ?></td>
                    <td style="width:15%;"><?= $item['date_start']; ?></td>
                    <td style="width:15%;"><?= $item['date_end'] > 0 ? $item['date_end'] : ''; ?></td>
                    <td style="width:10%;"><?= $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
