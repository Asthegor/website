<?php
$fileName = basename($_SERVER['REQUEST_URI']);
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
                <?= $item['bPage'] != 1 ? 'target="_blanck"' : ''; ?>
                ><?= $item['title']; ?>
            </a>
        </li>
        <?php
    }
    ?>
    <li class="nav-item">
        <a href="mailto:lacombe.dominique@outlook.fr">Me contacter</a>
    </li>
    <li id="nav-item-last-child" class="nav-item">
        <a href="<?= ROOT_URL.'views/language.php'; ?>">
            <?php
            $lm = new LanguageModel();
            $lmres = $lm->getImage($_SESSION['language']);
            $imgsrc = 'data:image/jpeg;base64,'.base64_encode($lmres['image']);
            ?>
            <img src="<?= $imgsrc; ?>" alt="<?= $_SESSION['language']; ?>" width="24" height="16"/>
        </a>
    </li>
</ul>