<h1>Tutoriel</h1>
<h5><a href="<?= ROOT_MNGT.'tutorials/add'; ?>">Nouveau tutoriel</a></h5>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:25%;">Titre</th>
            <th style="width:35%;">Description abrégée</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'tutorials/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:25%;"><?= urldecode($item['title']); ?></td>
                    <td style="width:35%;"><?= urldecode($item['short_desc']); ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
