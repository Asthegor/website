<?php
// Définition du fuseau horaire
date_default_timezone_set("Europe/Paris");
?>
  <footer style="clear: both;">
    <br>
    <h5 id="copyright">Copyright &copy; 
      <?php 
        $curYear = date('Y');
        echo COPY_YEAR . ((COPY_YEAR != $curYear) ? '-' . $curYear : ''); ?> -- LACOMBE Dominique</h5>
<?php
/*
    <div style="text-align:center;">
        <a href="https://github.com/Asthegor/">
            <?= $language == "FR" ? "Lien vers mon Github" : "Link to my Github" ?>
        </a>
    </div>
*/
?>
  </footer>
</body>

</html>