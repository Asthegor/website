<?php
$currentClass = get_class($this);

include_once(__DIR__.'/header.php');

if ($currentClass !== 'Home')
{
    if ($currentClass === 'Project')
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_ENCODED);
        if ((!isset($get['id']) && !is_numeric($get['id'])) || is_null($viewModel) || !isset($viewModel) || !$viewModel)
        {
            header('Location: '.ROOT_URL.'projects');
            return;
        }
    }
    ?>
    <header>
    <a href="<?= ROOT_URL; ?>">
      <img src="<?= ROOT_URL; ?>assets/images/logo.png" alt="Logo LACOMBE Dominique">
    </a>
    </header>
    <?php
    include_once(__DIR__.'/navbar.php');
}
?>
    <div class="main-content-wrapper">
        <?php
        if ($currentClass === 'Projects')
        {
            include_once(__DIR__.'/projects/sidebar.php');
        }
        else if ($currentClass === 'Resume')
        {
            include_once(__DIR__.'/resume/sidebar.php');
        }
        ?>
        <main role="main" class="container main-content">
            <?php 
            Messages::display();
            ?>
            <?php
            require($view);
            ?>
        </main>
    </div>
<?php
include_once(__DIR__.'/footer.php');
?>