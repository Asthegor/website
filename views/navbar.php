<?php
$fileName = basename($_SERVER['PHP_SELF']);
$language = $_SESSION['language'];
?>
<ul class="nav-bar">
  <?php
  $items = get_ItemsByCategory($web_bdd, 'NAV-ITEM', $language);
  while ($row = mysqli_fetch_assoc($items))
  {
    $item = '<li class="nav-item"><a ';
    if($fileName == $row['destination'])
    {
      $item .= 'class="active"';
    }
    $item .= 'href=" '.$row['destination'].'">'.$row['title'].'</a></li>';
    echo $item;
  }
  ?>
  <li id="nav-item-last-child" class="nav-item">
    <a href="<?php echo $language === 'FR' ? '?language=EN' : '?language=FR'; ?>">
      <img src="<?php echo get_LanguageImage($web_bdd, $language); ?>" alt="<?php echo $language; ?>" width="24" height="16"/>
    </a>
  </li>
</ul>