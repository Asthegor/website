<?php
$oldFramework = '';
foreach ($viewModel as $project)
{
    ?>
    <a class="project-list" href="<?= ROOT_URL.'project/display/'.$project['id']; ?>">
        <img class="project-list-image" src="data:image/jpeg;base64,<?= $project['img_blob']; ?>">
        <div class="project-list-overlay">
            <div class="project-list-overlay-back"></div>
            <div class="project-list-desc">
                <h4><?= urldecode($project['title']); ?></h4>
                <p><?= urldecode($project['short_desc']); ?></p>
            </div>
        </div>
    </a>
    <?php
}
?>
