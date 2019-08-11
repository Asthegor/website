<h1>Données de configuration</h1>
<h5><a href="<?= ROOT_MNGT.'configs/add'; ?>">Nouvelle donnée de configuration</a></h5>
<br>
<div class="navbar-index">
    <table style="width:95%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:25%;">Donnée</th>
            <th style="width:25%;">Valeur</th>
        </tr>
    </table>
    <?php
    foreach ($viewModelConfigs as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'configs/update/'.$item['id']; ?>">
            <table style="width:95%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:25%;"><?= $item['data']; ?></td>
                    <td style="width:25%;"><?= $item['value']; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
<hr>
<h1>Labels</h1>
<h5><a href="<?= ROOT_MNGT.'labels/add'; ?>">Nouveau label</a></h5>
<br>
<div class="navbar-index">
    <table style="width:95%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:25%;">Référence</th>
        </tr>
    </table>
    <?php
    foreach ($viewModelLabels as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'labels/update/'.$item['id']; ?>">
            <table style="width:95%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:25%;"><?= $item['ref']; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
