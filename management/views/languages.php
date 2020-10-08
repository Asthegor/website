<label for="language"><?= urldecode($frameworklbl) ?> :</label>
<select id="language" onchange="hideElements()">
    <?php foreach($languages as $language) { ?>
        <option value="<?= $language['code']; ?>"><?= $language['name']; ?></option>
    <?php } ?>
</select>

<script>
function hideElements()
{
    var fclass = document.getElementById("language").value;
    var list = document.getElementsByClassName("");
    var nbvisibleprojects = 0
    for(var i = 0; i < list.length; i++)
    {
        if (fclass == "f0" || list.item(i).classList.contains(fclass))
        {
            list.item(i).style.display = "inline-block";
            nbvisibleprojects++;
        }
        else
            list.item(i).style.display = "none";
    }
    document.getElementById("nbprojects").innerHTML = nbvisibleprojects;
}
</script>