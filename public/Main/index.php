<?php

use Core\Route\Route;

?>
@title=Главная@
<div class="container main-container">
    <div class="row mt-5">
        <h3>Фреймворк VVF</h3>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6 vertical-center"><h3>О фрейме</h3></div>
        <div class="col-lg-6">
            <ul>
                <li><a href="<?= Route::route('documentation'); ?>">Документация</a> </li>
                <li><a href="<?= Route::route('install'); ?>">Установка</a></li>
                <li><a href="<?= Route::route('technologies'); ?>">Технологии</a></li>
            </ul>
        </div>
    </div>
</div>