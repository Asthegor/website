<?php
include_once(__DIR__.'/projnavbar.php')
?>
<div class="project">
    <table><tbody><tr>
        <td id="project-image" style="vertical-align:top;">
            <?php
            if (isset($viewModel['image']) && $viewModel['image'] != "")
            {
                ?>
                <img src="<?= urldecode($viewModel['image']) ?>" alt="<?= htmlspecialchars(urldecode($viewModel['title'])); ?>" style="min-width:200px; min-height:250px; max-width:200px; max-height:250px;"/>
                <?php
            }
            else
            {
                ?>
                <image src="data:image/jpeg;base64,<?= $viewModel['img_blob']; ?>" alt="<?= urldecode($viewModel['title']); ?>" style="min-width:200px; min-height:250px; max-width:200px; max-height:250px;"/>
                <?php
            }
            ?>
                    
        </td>
        <td id="projet-desc" style="vertical-align:top;">
            <h1><?= urldecode($viewModel['title']); ?></h1>
            <div class="project-inline">
                <p class="project-inline project-inline-label"><?= urldecode($frameworkenginelbl) ?></p>
                <p><?= urldecode($viewModel['framework']); ?></p>
            </div>
            <?php
            if ($viewModel['version'] <> " (0000-00-00)")
            {
                ?>
                <div class="project-inline">
                    <p class="project-inline-label"><?= urldecode($actualversionlbl) ?></p>
                    <p><?= $viewModel['version']; ?></p>
                </div>
                <?php
            }
            if (!is_null($viewModel['first_date_project']))
            {
                ?>
                <div class="project-inline">
                    <p class="project-inline-label"><?= urldecode($initprojectlbl) ?></p>
                    <p><?= $viewModel['first_date_project'] ?></p>
                </div>
                <?php
                if (isset($viewDevlog) && count($viewDevlog) > 0)
                {
                    $dlm = new DevlogModel();
                    ?>
                    <div class="project-inline">
                        <p class="project-inline-label"><?= urldecode($projectdurationlbl) ?></p>
                        <p><?= $dlm->getSessionTime(); ?></p>
                    </div>
                    <?php
                }
                ?>
                <?php
            }
            if (!empty($viewModel['website']))
            {
                ?>
                <div class="project-inline">
                    <p class="project-inline-label"><?= urldecode($websitelbl) ?></p>
                    <a target="_blank" href="<?= urldecode($viewModel['website']) ?>"><?= urldecode($viewModel['website']) ?></a>
                </div>
                <?php
            }
            if (!empty($viewModel['file']))
            {
                ?>
                <div class="project-inline">
                    <p class="project-inline-label"><?= urldecode($downloadlinklbl) ?></p>
                    <a href="<?= ROOT_URL.'download.php?file='.$viewModel['file']; ?>"><?= urldecode($viewModel['file']); ?></a>
                </div>
                <?php
            }
            ?>
            </div>
        </td>
    </tbody></tr></table>

    <?php
    if (isset($viewModel['sections']) && !empty($viewModel['sections']))
    {
        ?>
        <br>
        <?php foreach ($viewModel['sections'] as $section)
        {
            ?>
            <h4 class="project-inline-label"><?= urldecode($section['title']); ?></h4>
            <p><?= urldecode($section['content']); ?></p>
            <?php
        }
    }
    else
    {
        ?>
        <h4 class="project-inline-label">Description :</h4>
        <p><?= urldecode($viewModel['description']); ?></p>
        <?php
    }

    if (!empty($viewModel['iframe']))
        echo '<iframe '.str_replace('&#34;', '"', urldecode($viewModel['iframe'])).'></iframe>';
    
    if (isset($viewDevlog) && count($viewDevlog) > 0)
    {
        ?>
        <br>
        <h4 class="project-inline-label">Devlog</h4>
        <?php
        foreach ($viewDevlog as $devlog)
        {
            ?>
            <p><a href="<?= ROOT_URL.'devlog/'.$devlog['id']; ?>"><?= urldecode($devlog['title']); ?></a>&nbsp;<small><i>(<?= $devlog['date_creation']; ?>)</i></small></p>
            <?php
        }
    }
    ?>
</div>
