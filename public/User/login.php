<?php

use VVF\Route\Route;

?>
@title=Логин@

<div class="container">
    <form action="<?= Route::route('login') ?>" method="POST">
        <p>Login <input type="text" name='login'></p>
        <p>Pass <input type="text" name='pass'></p>
        <button type="submit">login</button>
    </form>
</div>