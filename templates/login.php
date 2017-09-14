<?php ?>

<nav class="nav">
    <ul class="nav__list container">
        <li class="nav__item">
            <a href="all-lots.html">Доски и лыжи</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Крепления</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Ботинки</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Одежда</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Инструменты</a>
        </li>
        <li class="nav__item">
            <a href="all-lots.html">Разное</a>
        </li>
    </ul>
</nav>
<form class="form container<?=count($errors) > 0 ? ' form--invalid' : '' ?>" action="login.php" enctype="application/x-www-form-urlencoded" method="post" novalidate> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item<?=in_array('email', $errors) ? ' form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$_POST['email'] ?? '' ?>" required>
        <span class="form__error"><?=in_array('email', $errors) ? 'Введите e-mail' : '' ?></span>
    </div>
    <div class="form__item form__item--last<?=in_array('password', $errors) ? ' form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" required>
        <span class="form__error"><?=in_array('email', $errors) ? 'Введите пароль' : '' ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>

