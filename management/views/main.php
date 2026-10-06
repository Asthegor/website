<?php
include_once(__DIR__.'/header.php');
?>
  <main role="main" class="container">
    <?php 
    Messages::display();
    ?>
    <?php
    require($view);
    ?>
  </main>
  <script>
      tinymce.init({
          selector: 'textarea',
          plugins: [
              // Core editing features
              'anchor', 'autolink', 'charmap', 'code', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'image'
          ],
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          tinycomments_mode: 'embedded',
          uploadcare_public_key: 'b33d621a5648b59c67b2',
      });
  </script>
<?php
include_once(__DIR__.'/footer.php');
?>