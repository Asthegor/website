<script>
/*
    tinymce.init({
        selector: 'textarea.noiframe',
        plugins: 'lists link image table',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image'
    });
    */
    tinymce.init({
        selector: 'textarea.noiframe',
        plugins: [
            // Core editing features
            'anchor', 'autolink', 'charmap', 'code', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        uploadcare_public_key: 'b33d621a5648b59c67b2',
    });
</script>
<?php
if ($_SERVER["REQUEST_URI"] == __FILE__)
  header('Location: '.ROOT_URL);
?>
  </div>
  <footer>
    <h5 id="copyright">Copyright &copy; 
    <?php 
    $curYear = date('Y');
    echo COPY_YEAR . ((COPY_YEAR != $curYear) ? '-' . $curYear : ''); ?> -- LACOMBE Dominique</h5>
  </footer>
</body>
</html>
