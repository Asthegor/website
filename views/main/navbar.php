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
        href="<?php echo ROOT_URL.$item['destination']; ?>"><?php echo $item['title']; ?>
      </a>
    </li>
    <?php
  }
  ?>
  <li id="nav-item-last-child" class="nav-item">
    <a href="<?php echo ROOT_URL.substr($_SERVER['REQUEST_URI'], 1); ?>">
      <img src="data:image/jpeg;base64,
        <?php
        $lm = new LanguageModel();
        $lmres = $lm->getImage($_SESSION['language']);
        echo base64_encode($lmres['image']);
        ?>" alt="<?php echo $_SESSION['language'] == 'FR' ? 'EN' : 'FR'; ?>" width="24" height="16"/>
    </a>
  </li>
</ul>
