<?php
$fileName = basename($_SERVER['PHP_SELF']);
?>
<ul class="nav-bar">
  <?php
  $navbar = new NavBarModel();
  $items = $navbar->getVisibleItems($_SESSION['language']);
  foreach ($items as $item)
  {
    ?>
    <li class="nav-item">
      <a
        <?php
        if($fileName == $item['destination'])
        {
          ?>
          class="active"
          <?php
        }
        ?>
        href="<?= ($item['bPage'] ? ROOT_URL : '').$item['destination']; ?>"
        <?= !$item['bPage'] ? 'target="_blanck"' : ''; ?>
        ><?= $item['title']; ?>
      </a>
    </li>
    <?php
  }
  ?>
  <li id="nav-item-last-child" class="nav-item">
    <a href="<?= ROOT_URL.'views/main/language.php'; ?>">
      <?php
      $language = $_SESSION['language'] == 'EN' ? 'FR' : 'EN';
      $lm = new LanguageModel();
      $lmres = $lm->getImage($language);
      $imgsrc = 'data:image/jpeg;base64,'.base64_encode($lmres['image']);
      ?>
      <img src="<?= $imgsrc; ?>" alt="<?= $language; ?>" width="24" height="16"/>
    </a>
  </li>
</ul>