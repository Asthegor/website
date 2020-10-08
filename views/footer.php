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
  </footer>
</body>

</html>