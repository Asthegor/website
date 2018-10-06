<?php
$oldFramework = '';
foreach ($viewModel as $project)
{
    ?>
    <div class="project">
        <img class="project-image" src="data:image/jpeg;base64,<?= $project['img_blob']; ?>">
        <div class="project-overlay">
            <div class="project-desc">
                <h4><?= urldecode($project['title']); ?></h4>
                <p><?= urldecode($project['desc_'.strtolower($_SESSION['language'])]); ?></p>
            </div>
        </div>
    </div>
    <?php
}
?>
