<h1>Images</h1>
<h5><a href="<?= ROOT_MNGT.'images/add'; ?>">Nouvelle image</a></h5>
<br>
<?php
$dir = "";
foreach ($viewModel as $file)
{
    
    if ($dir <> $file->directory)
    {
        if (!empty($dir))
        {
            ?>
            <hr>
            <?php
        }
        ?>
        <h4><?= $file->directory; ?></h4>
        <?php
    }
    ?>
    
    <a href="<?= ROOT_URL.'assets/images/'.$file->directory.'/'.$file->name; ?>" target="_blank"><?= $file->name; ?></a>
    <br>
    <?php
    $dir = $file->directory;
}
?>