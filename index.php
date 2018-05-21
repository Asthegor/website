<?php
include('views/header.php');
$items = get_ItemsByCategory($web_bdd, 'CONTENT', $_SESSION['language']);
while ($row = mysqli_fetch_assoc($items))
{
?>
  <div class="summary">
    <a href="<?php echo $row['destination']; ?>">
      <?php if (isset($row['image'])) : ?>
        <img src="<?php echo 'data:image/jpeg;base64,'.base64_encode($row['image']); ?>" alt="<?php echo $row['title']; ?>"/>
      <?php endif; ?>
      <h1><?php echo $row['title']; ?></h1>
    </a>
  </div>
<?php
}
?>
<?php
include('views/footer.php');
?>