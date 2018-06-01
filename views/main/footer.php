  <footer>
    <h5 id="copyright">Copyright &copy; 
      <?php 
      $curYear = date('Y');
      echo COPY_YEAR . ((COPY_YEAR != $curYear) ? '-' . $curYear : ''); ?> -- LACOMBE Dominique</h5>
    <h4 style="width: 100%; text-align: center;">
      <a style="color: white;" href="https://github.com/LarryFr/website" target="_blank">
        <?= $_SESSION['language'] == 'FR' ? 'Code source du site' : 'Website Source Code'; ?>
      </a>
    </h4>
  </footer>
</body>
</html>