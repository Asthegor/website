<?php
$is_project_page = true; // Obligatoire pour inclure le fichier css dédié à la page

// Initialisation des listes spécifiques à chaque zone
$zone1_projects = [];
$zone2_projects = [];
$zone3_projects = [];

// Le tableau $projects vient de votre requête SQL
foreach ($projects as $project)
{
    switch ($project['zone'])
    {
        case 1:
            $zone1_projects[] = $project;
            break;
        case 2:
            $zone2_projects[] = $project;
            break;
        case 3:
            $zone3_projects[] = $project;
            break;
        default:
            break;
    }
}
?>
<div class="projects-list">
    <br>
    <section class="zone-featured">
        <h2 class="zone-title" id="<?= $projectlistzone1id; ?>"><?= $projectlistzone1lbl; ?></h2>
        <?php
        foreach($zone1_projects as $project)
        {
            ?>
            <a href="project/<?= $project['slug'] ?>">
            <article class="featured-card">
                <div class="card-visual-featured">
                    <?php
                    if (isset($project['image']) && $project['image'] != "")
                    {
                        ?>
                        <img src="<?= urldecode($project['image']) ?>" alt="<?= htmlspecialchars(urldecode($project['title'])); ?>">
                        <?php
                    }
                    else
                    {
                        ?>
                        <img src="data:image/jpeg;base64,<?= $project['img_blob'] ?? ''; ?>" alt="<?= htmlspecialchars(urldecode($project['title'])); ?>">
                        <?php
                    }
                    ?>
                    
                    <div class="visual-overlay"></div>
                </div>
        
                <div class="card-content-featured">
                    <h3 class="card-title-featured"><?= htmlspecialchars(urldecode($project['title'])); ?></h3>
                    <span class="card-date-featured"><?= date('Y', strtotime($project['first_date_project'])) ?></span><br>
                    <div class="tags-list-featured">
                        <?php
                        /*
                        <span class="badge-tag">C#</span>
                        <span class="badge-tag">ServiceLocator</span>
                        <span class="badge-tag">GUI System</span>
                        <span class="badge-tag">Tiled</span>
                        <span class="badge-tag">Crypto</span>
                        <span class="badge-tag">Scene Manager</span>
                        */
                        ?>
                    </div>
                    <div class="card-description-featured"><?= urldecode($project['short_desc']); ?></div>
                    <p><?= $projectlistlinklbl; ?></p>
                </div>
            </article>
            </a>
            <?php
        }
        ?>
    </section>
    <br>
    <section class="zone-grid">
        <h2 class="zone-title" id="<?= $projectlistzone2id; ?>"><?= $projectlistzone2lbl; ?></h2>
        <?php
        foreach ($zone2_projects as $project)
        {
            ?>
            <a href="project/<?= $project['slug'] ?>">
            <article class="project-card">
                
                <div class="card-visual">
                    <?php $imgSrc = 'data:image/jpeg;base64,' . ($project['img_blob'] ?? ''); ?>
                    <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars(urldecode($project['title'])) ?>">
                </div>
    
                <div class="card-content">
                    <div class="card-header">
                        <span class="badge-framework"><?= htmlspecialchars(urldecode($project['framework'])) ?? 'Non défini' ?></span>
                        <span class="card-date"><?= date('Y', strtotime($project['first_date_project'])) ?></span>
                    </div>
                    <h3 class="card-title"><?= htmlspecialchars(urldecode($project['title'])) ?></h3>
                    <div class="card-description">
                        <?= urldecode($project['short_desc']) ?>
                    </div>
                    <p><?= $projectlistlinklbl; ?></p>
                </div>
            </article>
            </a>
            <br>
            <?php
        }
        ?>
    </section>
    <br>
    <section class="zone-list">
        <h2 class="zone-title" id="<?= $projectlistzone3id; ?>"><?= $projectlistzone3lbl; ?></h2>
        <div class="list-layout">
            <?php
            foreach ($zone3_projects as $project)
            {
                ?>
                <article class="list-item">
                    <div class="item-info">
                        <span class="item-year"><?= date('Y', strtotime($project['first_date_project'])) ?></span>
                        <h3 class="item-title"><?= htmlspecialchars(urldecode($project['title'])) ?></h3>
                    </div>
                    <div class="item-meta">
                        <span class="badge-framework"><?= urldecode($project['framework']) ?? 'Non défini' ?></span>
                        <a href="project/<?= $project['slug'] ?>" class="btn-detail"><?= $projectlistlinklbl; ?></a>
                    </div>
                </article>
                <?php
            }
            ?>
        </div>
    </section>
</div>
