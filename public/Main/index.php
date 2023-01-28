<?php

use Core\Route\Route;

?>
@title=Главная@
<div class="container main-container">
    <div class="row mt-5 mb-5">
        <h3>Фреймворк VVF</h3>
    </div>
</div>
<div class="row ">
    <div class="col-lg-6 black-bg">
        <p>Данный фреймворк создается на основе желания проверить свои умения <br>
            Занимаюсь программированием с 2020 года <br>
            Основной язык программирования PHP</p>
    </div>
    <div class="col-lg-6 vertical-center">
        <h3>Обо мне</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 vertical-center">
        <h3>О фрейме</h3>
    </div>
    <div class="col-lg-6 black-bg">
        <ul>
            <li><a href="<?= Route::route('documentation'); ?>">Документация</a> </li>
            <li><a href="<?= Route::route('install'); ?>">Установка</a></li>
            <li><a href="<?= Route::route('technologies'); ?>">Технологии</a></li>
        </ul>
    </div>
</div>