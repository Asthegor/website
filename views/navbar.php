<?php
$fileName = basename($_SERVER['PHP_SELF']);
?>
<ul class="nav-bar">
  <?php
Profiling::StartChrono('NavBar_datas');
  $navbar = new NavBarModel();
  $items = $navbar->getVisibleItems($_SESSION['language']);
  Profiling::EndChrono('NavBar_datas');
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
    <a href="<?= ROOT_URL.'views/language.php'; ?>">
      <?php
      $language = $_SESSION['language'] == 'EN' ? 'FR' : 'EN';
      $lm = new LanguageModel();
      Profiling::StartChrono('Image_Language');
      $lmres = $lm->getImage($language);
      Profiling::EndChrono('Image_Language');
      $imgsrc = 'data:image/jpeg;base64,'.base64_encode($lmres['image']);
      ?>
      <img src="<?= $imgsrc; ?>" alt="<?= $language; ?>" width="24" height="16"/>
    </a>
  </li>
</ul>