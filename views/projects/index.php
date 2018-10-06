<?php
$oldFramework = '';
foreach ($viewModel as $project)
{
    ?>
    <div class="project">
        <img class="project-image" src="data:image/jpeg;base64,<?= $project['img_blob']; ?>">
        <div class="project-overlay">
            <div class="project-desc">
                <p><?= urldecode($project['title']); ?></p>
            </div>
        </div>
    </div>
    <?php
}
?>
