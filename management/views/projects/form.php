<?php
require_once('views/projectnavbar/projectnavbar.php');
function render_sections($lang, $sections_data) {
    $label_title = ($lang === 'fr') ? 'Titre de Section (FR)' : 'Section Title (EN)';
    $label_content = ($lang === 'fr') ? 'Contenu de Section (FR)' : 'Section Content (EN)';
    $btn_text = ($lang === 'fr') ? 'Supprimer la paire' : 'Remove Pair';

    $output = '';

    if (!empty($sections_data)) {
        foreach ($sections_data as $section) {
            $section_id = htmlspecialchars($section['id'] ?? uniqid());
            $title = htmlspecialchars(urldecode($section['title'] ?? ''));
            $content = htmlspecialchars(urldecode($section['content'] ?? ''));
            $output .= '<div class="form-group section-item" data-id="'.$section_id.'">
                            <label>'.$label_title.'</label>
                            <input type="text" name="sections_'.$lang.'['.$section_id.'][title]" value="'.$title.'" required />
                            <label>'.$label_content.'</label>
                            <textarea class="noiframe" rows="10" name="sections_'.$lang.'['.$section_id.'][content]" required>'.$content.'</textarea>
                            <button type="button" class="btn btn-danger btn-sm remove-section" data-id="'.$section_id.'">'.$btn_text.'</button>
                            <hr style="margin-top: 10px;">
                        </div>';
        }
    }
    return $output;
}
?>
<h1>Projets</h1>
<form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php if (isset($viewModel['id']))
    {
        ?>
        <div class="form-group">
            <label>ID</label>
            <input type="text" name="id" value="<?= $viewModel['id']; ?>" readonly />
        </div>
        <?php
    }
    ?>
    <div class="form-group">
        <label>Framework/Engin</label>
        <select name="framework" required>
            <option value=""></option>
            <?php
            $fm = new FrameworksModel();
            $fmlist = $fm->getList();
            foreach ($fmlist as $item)
            {
                ?>
                <option value="<?= $item['id']; ?>" <?= isset($viewModel['id_Framework']) ? ($viewModel['id_Framework'] == $item['id'] ? 'selected' : '') : ''; ?>><?= $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Zone</label>
        <select name="zone">
            <option value="1" <?= isset($viewModel) && $viewModel['zone'] == 1 ? 'selected' : ''; ?>>1</option>
            <option value="2" <?= isset($viewModel) && $viewModel['zone'] == 2 ? 'selected' : ''; ?>>2</option>
            <option value="3" <?= isset($viewModel) && $viewModel['zone'] == 3 ? 'selected' : ''; ?>>3</option>
        </select>
        <?php
        if (isset($viewModel) && $viewModel['zone'] > 1)
        {
            ?>
            <label>Zone Order</label>
            <input type="text" name="zone_order" value="<?= $viewModel['zone_order']; ?>" />
            <?php
        }
        ?>
    </div>
    
    <ul class="nav nav-tabs" id="langTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="fr-tab" data-toggle="tab" href="#fr-pane" role="tab" aria-controls="fr-pane" aria-selected="true">Français (FR)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="en-tab" data-toggle="tab" href="#en-pane" role="tab" aria-controls="en-pane" aria-selected="false">Anglais (EN)</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane show active" id="fr-pane" role="tabpanel" aria-labelledby="fr-tab">
            <div class="form-group">
                <label>Titre français</label>
                <input type="text" name="title_fr" value="<?= isset($viewModel['title_fr']) ? urldecode($viewModel['title_fr']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Description courte française</label>
                <textarea class="noiframe" rows="6" cols="150" name="desc_fr"><?= isset($viewModel['desc_fr']) ? urldecode($viewModel['desc_fr']) : ''; ?></textarea>
            </div>
            <hr>
            <h3>Sections Françaises de l'Étude de Cas</h3>
            <div id="sections-fr-container">
                <?= render_sections('fr', $viewModel['sections_fr'] ?? []); ?>
            </div>
            <button type="button" class="btn btn-success btn-sm add-section-btn">Ajouter Nouvelle Section (FR+EN)</button>
        </div>
        <div class="tab-pane" id="en-pane" role="tabpanel" aria-labelledby="en-tab">
            <div class="form-group">
                <label>Titre anglais</label>
                <input type="text" name="title_en" value="<?= isset($viewModel['title_en']) ? urldecode($viewModel['title_en']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label>Description courte anglaise</label>
                <textarea class="noiframe" rows="6" cols="150" name="desc_en"><?= isset($viewModel['desc_en']) ? urldecode($viewModel['desc_en']) : ''; ?></textarea>
            </div>
            <hr>
            <h3>English Sections for Case Study</h3>
            <div id="sections-en-container">
                <?= render_sections('en', $viewModel['sections_en'] ?? []); ?>
            </div>
            <button type="button" class="btn btn-success btn-sm add-section-btn">Add New Section (FR+EN)</button>
        </div>
    </div>
    <hr style="margin-top: 20px;">
    <div class="form-group">
        <label>Site web</label>
        <input type="text" name="website" value="<?= isset($viewModel['website']) ? urldecode($viewModel['website']) : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="dateproject" value="<?= isset($viewModel['first_date_project']) ? $viewModel['first_date_project'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Numéro de version</label>
        <input type="text" name="num_version" value="<?= isset($viewModel['num_version']) ? $viewModel['num_version'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Date de la version</label>
        <input type="date" name="date_version" value="<?= isset($viewModel['date_version']) ? $viewModel['date_version'] : ''; ?>" />
    </div>
    <hr>
    <div class="form-group">
        <label>Image</label>
        <img src="<?= isset($viewModel['image']) ? urldecode($viewModel['image']) : ''; ?>" alt="" style="border:2px;padding:2px;margin:2px;"/>
        <input class="form-group" type="text" name="image" value="<?= isset($viewModel['image']) ? urldecode($viewModel['image']) : ''; ?>" style="margin-left:140px;">
    </div>
    <hr>
    <div class="form-group">
        <label>Fichier</label>
        <a href="<?= isset($viewModel['file']) ? urldecode($viewModel['file']) : ''; ?>"><?= isset($viewModel['file']) ? urldecode($viewModel['file']) : ''; ?></a>
        <input type="text" name="file" value="<?= isset($viewModel['file']) ? urldecode($viewModel['file']) : ''; ?>" />
    </div>
    <div class="form-group">
        <label>iframe</label>
        <textarea rows="2" cols="150" name="iframe"><?= isset($viewModel['iframe']) ? urldecode($viewModel['iframe']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>projects">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'projects/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
<style>
/* Style minimal pour les onglets si vous n'utilisez pas Bootstrap */
.nav-tabs { border-bottom: 1px solid #ddd; padding-left: 0; margin-bottom: 15px; }
.nav-tabs .nav-item { display: inline-block; }
.nav-tabs .nav-link { display: block; padding: 10px 15px; border: 1px solid transparent; border-radius: 4px 4px 0 0; }
.nav-tabs .nav-link.active { background-color: #fff; border-color: #ddd #ddd #fff; }
.tab-content .tab-pane { padding: 15px 0; border-top: 1px solid #ddd; }
.tab-content .tab-pane.active { display: block; }
.tab-content .tab-pane.fade { display: none; }
.tab-content .tab-pane.fade.show { display: block; }
</style>
<script>
$(document).ready(function() {
    
    // ----------------------------------------------------------------------
    // I. GESTION DES ONGLETS
    // ----------------------------------------------------------------------
    
    // Fonctionnalité de base pour le changement d'onglet (si pas de Bootstrap JS)
    $('.nav-tabs .nav-link').on('click', function(e) {
        e.preventDefault();
        var targetPane = $(this).attr('href');
        
        // Supprime 'active' et 'show' de tous les liens et contenus
        $('.nav-tabs .nav-link').removeClass('active');
        $('.tab-content .tab-pane').removeClass('active show');
        
        // Ajoute 'active' et 'show' au lien et au contenu cliqué
        $(this).addClass('active');
        $(targetPane).addClass('active show');
    });

    // ----------------------------------------------------------------------
    // II. GESTION DES SECTIONS DYNAMIQUES (PAIRES FR/EN)
    // ----------------------------------------------------------------------
    
    // Crée la paire de sections FR et EN avec le même ID unique
    function createNewSectionPair() {
        // L'ID unique est la clé de liaison entre les sections FR et EN en PHP
        var uniqueId = Date.now(); 
        
        // --- Section FRANÇAISE ---
        var sectionFrHtml = `
            <div class="form-group section-item" data-id="${uniqueId}">
                <label>Titre de Section (FR)</label>
                <input type="text" name="sections_fr[${uniqueId}][title]" value="" required />
                
                <label>Contenu de Section (FR)</label>
                <textarea class="noiframe" rows="10" name="sections_fr[${uniqueId}][content]" required></textarea>
                
                <button type="button" class="btn btn-danger btn-sm remove-section" data-id="${uniqueId}">Supprimer la paire</button>
                <hr style="margin-top: 10px;">
            </div>
        `;
        
        // --- Section ANGLAISE ---
        var sectionEnHtml = `
            <div class="form-group section-item" data-id="${uniqueId}">
                <label>Section Title (EN)</label>
                <input type="text" name="sections_en[${uniqueId}][title]" value="" required />
                
                <label>Section Content (EN)</label>
                <textarea class="noiframe" rows="10" name="sections_en[${uniqueId}][content]" required></textarea>
                
                <button type="button" class="btn btn-danger btn-sm remove-section" data-id="${uniqueId}">Remove pair</button>
                <hr style="margin-top: 10px;">
            </div>
        `;
        
        $('#sections-fr-container').append(sectionFrHtml);
        $('#sections-en-container').append(sectionEnHtml);
    }

    // Événement pour ajouter une section (via le bouton dans l'onglet FR)
    $('.add-section-btn').on('click', function()
    {
        createNewSectionPair();
    });

    // Événement pour supprimer une paire de sections (FR et EN)
    $(document).on('click', '.remove-section', function()
    {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette paire de sections (FR et EN) ? Cette action est irréversible après sauvegarde."))
        {
            var idToRemove = $(this).data('id');
            
            // Supprime la section FR et sa paire EN correspondante, en se basant sur le data-id
            $('.section-item[data-id="' + idToRemove + '"]').remove();
        }
    });
});
</script>