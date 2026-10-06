<?php
require_once('views/resumenavbar/resumenavbar.php');
?>
<h1>Curriculum Vitae</h1>
<form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
        <p>Charger un nouveau CV français</p>
        <div>
            <input type="file" name="cvfr" id="cvfr">
        </div>
    </div>
    <div class="form-group">
        <p>Charger un nouveau CV anglais</p>
        <div>
            <input type="file" name="cven" id="cven">
        </div>
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>cvs">Cancel</a>
</form>