<h1>Poèmes</h1>
<h5><a href="<?= ROOT_MNGT.'poeme/add'; ?>">Nouveau poème</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:95%;">Titre</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'poeme/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:95%;"><?= urldecode($item['title']); ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
