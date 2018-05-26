<h1>Expériences</h1>
<h2><a href="<?php echo ROOT_MNGT.'resume/add'; ?>">Nouvelle expérience</a></h2>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:20%;">Titre</th>
            <th style="width:15%;">Société</th>
            <th style="width:15%;">Ville</th>
            <th style="width:15%;">Début</th>
            <th style="width:15%;">Fin</th>
            <th style="width:15%;">Visible</td>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
        if ($_SESSION['language'] == 'EN')
        {
            $title = $item['title_en'];
            $city = $item['city_en'].' ('.$item['country_en'].')';
        }
        else
        {
            $title = $item['title_fr'];
            $city = $item['city_fr'].' ('.$item['country_fr'].')';
        }
        ?>
        <div style="display: inline-block; width:100%">
            <a href="<?php echo ROOT_MNGT.'resume/update/'.$item['id']; ?>">
                <table style="width:80%;">
                    <tr>
                        <td style="width:20%;"><?php echo $title; ?></td>
                        <td style="width:15%;"><?php echo $item['company']; ?></td>
                        <td style="width:15%;"><?php echo $city; ?></td>
                        <td style="width:15%;"><?php echo $item['date_start']; ?></td>
                        <td style="width:15%;"><?php echo $item['date_end']; ?></td>
                        <td style="width:15%;"><?php echo $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                </table>
            </a>
        </div>
    <?php
    }
    ?>
</div>
