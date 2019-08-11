<br>
<label for="frameworkselect"><?= urldecode($frameworklbl) ?> :</label>
<select id="frameworkselect" onchange="hideElements()">
    <option value="f0">Tous</option>
    <?php foreach($frameworks as $framework) { ?>
        <option value="f<?= $framework['id']; ?>"><?= $framework['name']; ?></option>
    <?php } ?>
</select>
<hr>
<?php
foreach ($viewModel as $project) { ?>
    <a class="project-list f<?= $project['id_Framework']; ?>" href="<?= ROOT_URL.'project/display/'.$project['id']; ?>">
        <img class="project-list-image" src="data:image/jpeg;base64,<?= $project['img_blob']; ?>">
        <div class="project-list-overlay">
            <div class="project-list-overlay-back"></div>
            <div class="project-list-desc">
                <h4><?= urldecode($project['title']); ?></h4>
                <p><?= urldecode($project['short_desc']); ?></p>
                <h6 class="project-views"><?= urldecode($projectviews); ?> : <?= urldecode($project['nbViews']); ?><br>
                <?= urldecode($projectuniqueviews); ?> : <?= urldecode($project['unique_views']); ?></h6>
            </div>
        </div>
    </a>
<?php } ?>
<script>
function hideElements()
{
    var fclass = document.getElementById("frameworkselect").value;
    var list = document.getElementsByClassName("project-list");
    for(var i = 0; i < list.length; i++)
    {
        if (fclass == "f0" || list.item(i).classList.contains(fclass))
            list.item(i).style.display = "inline-block";
        else
            list.item(i).style.display = "none";
    }
}
</script>