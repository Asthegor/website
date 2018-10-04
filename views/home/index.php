<div id="background1">
<img src="<?= ROOT_URL; ?>assets/images/backgrounds/background2.jpg"/>
<h1 id="maintitle"><?= ConfigModel::getConfig('MAIN_TITLE_'.$language); ?></h1>
</div>
<script>
$(function(){
    $(".flip").flip({
        trigger: 'hover'
    });
});

// $( "#maintitle" ).click(function() {
//   $( "#maintitle" ).fadeOut( 2000, "linear");
// });

// $(document).ready(function(){
//     setInterval(function(){
//         $('#maintitle').fadeOut(2000, "linear").fadeIn();
//         // $('#maintitle').fadeIn();
//         }, 3000);
// });
</script>

<?php
foreach ($viewModel as $item)
{
    ?><div class="flip">  
        <div class="summary front ">
            <a href="<?= ROOT_URL.$item['destination']; ?>">
                <h1><?= $item['title_'.strtolower($_SESSION['language'])]; ?></h1>
            </a>
        </div>
        <div class=" summary back ">
            <p><?= $item['desc_'.strtolower($_SESSION['language'])]; ?></p>
        </div> 
    </div>
    <?php
}
?>

