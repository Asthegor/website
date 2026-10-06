<aside class="sidebar">
    <!-- Photo -->
    <img class="sidebar__photo" src="<?= ROOT_URL; ?>assets/images/Dominique_LACOMBE.png" alt="LACOMBE Dominique">

    <!-- Liens -->
    <div class="sidebar__section">
        <h3><?= $lbl_links ?></h3>
        <ul >
            <?php foreach ($links ?? [] as $link): ?>
                <li>
                    <a class="sidebar__links" href="<?= htmlspecialchars(urldecode($link['url'])) ?>" target="_blank">
                        <?= htmlspecialchars(urldecode($link['name'])) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    /*
    <!-- Compétences -->
    <div class="sidebar__section">
        <h3>Compétences</h3>
        <?php foreach ($sidebar['skills'] ?? [] as $category): ?>
            <div class="sidebar__skills-category">
                <strong><?= htmlspecialchars($category['category']) ?></strong>
                <ul>
                    <?php foreach ($category['items'] as $skill): ?>
                        <li><?= htmlspecialchars($skill) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
    */
    ?>
</aside>