<?php
$fileName = basename($_SERVER['REQUEST_URI']);
$labelmodel = new LabelsModel();
?>
<ul class="nav-bar">
    <?php
    $navbar = new NavBarModel();
    $items = $navbar->getVisibleItems($_SESSION['language']);
    foreach ($items as $item)
    {
        ?>
        <li class="nav-item">
            <a <?=  (($fileName == "" && strtolower($item['destination']) == 'home') || $fileName == $item['destination'])
                    ? ' class="active" '
                    : ''; ?>
                href="<?= ($item['bPage'] == 1 ? ROOT_URL : '').$item['destination']; ?>"
                <?= $item['bPage'] != 1 ? 'target="_blank"' : ''; ?>
                ><?= $item['title']; ?>
            </a>
        </li>
        <?php
    }
    ?>
    <li class="nav-item">
        <a href="mailto:lacombe.dominique@outlook.fr"><?= $labelmodel->getLabelByRef('contact'); ?></a>
    </li>
    <li id="nav-item-last-child" class="nav-item">
        <a href="<?= ROOT_URL.'views/language.php'; ?>" class="language-toggle">
            <?php 
            // Affiche la langue alternative en texte clair
            $lang_text = ($_SESSION['language'] == 'FR') ? 'English' : 'Français';
            $lang_code = ($_SESSION['language'] == 'FR') ? 'EN' : 'FR';
            echo '<span class="lang-code">['.$lang_code.']</span> ' . $lang_text;
            ?>
        </a>
    </li>
</ul>
