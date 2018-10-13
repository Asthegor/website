<?php
Profiling::StartChrono('Header');
include_once(__DIR__.'/header.php');
Profiling::EndChrono('Header');
?>

  <main role="main" class="container">
    <?php 
    Profiling::StartChrono('MessageDisplay');
    Messages::display();
    Profiling::EndChrono('MessageDisplay');
    ?>
    <?php
    require($view);
    ?>
  </main>
<?php
Profiling::StartChrono('Footer');
include_once(__DIR__.'/footer.php');
Profiling::EndChrono('Footer');
?>