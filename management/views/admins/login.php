<?php
include_once('../views/header.php');
?>
<div class="panel-body">
    <?php Messages::display(); ?>
    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" class="form-control" />
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" />
        </div>
        <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    </form>
</div>
<?php
include_once('../views/footer.php');
?>