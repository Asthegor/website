<h1>Statistiques du site</h1>
<br>
<table style="width: 100%;">
    <tr>
        <th style="width: 30%;"></th>
        <th style="width: 15%;">Nbre Enreg.</th>
        <th style="width: 15%;">Affichés</th>
        <th style="width: 15%;">Masqués</th>
    </tr>
</table>
<?php
foreach ($viewModel as $datas)
{
    ?>
    <a href="<?php echo ROOT_MNGT.$datas['dest']; ?>">
        <table style="width:100%;">
            <tr>
                <td style="width: 30%;"><?php echo $datas['title']; ?></td>
                <?php
                foreach ($datas['datas'] as $number)
                {
                    ?>
                    <td style="width: 15%; text-align: center;"><?php echo $number; ?></td>
                    <?php
                }
                ?>
            </tr>
        </table>
    </a>
    <?php
}
?>
