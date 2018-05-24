<form class="form-signin" action="<?= \helpers\Url::to('admin/login') ?>" method="post">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input name="user[username]" type="text" class="form-control" placeholder="Login or username" required=""
           autofocus="">
    <input name="user[password]" type="password" class="form-control" placeholder="Password" required="">
    <?php if ($model->errors) { ?>
        <div class="alert alert-danger">
            <strong>Oh snap!</strong> Неверный логин или пароль.
        </div>
    <?php } ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <a href="<?= \helpers\Url::to('task/index') ?>"> Назад </a>
</form>
