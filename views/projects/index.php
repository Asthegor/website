<?php
$oldFramework = '';
foreach ($viewModel as $project)
{
    ?>
    <a class="project" href="<?= ROOT_URL.'project/display/'.$project['id']; ?>">
        <img class="project-image" src="data:image/jpeg;base64,<?= $project['img_blob']; ?>">
        <div class="project-overlay">
            <div class="project-desc">
                <h4><?= urldecode($project['title']); ?></h4>
                <p><?= urldecode($project['desc_'.strtolower($_SESSION['language'])]); ?></p>
            </div>
        </div>
    </a>
    <?php
}
?>
