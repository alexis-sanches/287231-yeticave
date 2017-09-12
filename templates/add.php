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
<form class="form form--add-lot container<?=count($errors) ? ' form--invalid' : '' ?>" action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item<?=in_array('lot-name', $errors) ? ' form__item--invalid' : '' ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$_POST['lot-name'] ?? '' ?>" required>
            <span class="form__error"><?=in_array('lot-name', $errors) ? 'Проверьте, что поле заполнено' : '' ?></span>
        </div>
        <div class="form__item<?=in_array('category', $errors) ? ' form__item--invalid' : '' ?>">
            <label for="category">Категория</label>
            <select id="category" name="category" required>
                <option value="">Выберите категорию</option>
                <?php foreach ($categories as $key => $value): ?>
                <option value="<?=$key; ?>" <?=$_POST['category'] == $key ? 'selected' : '' ?>><?=$value; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?=in_array('category', $errors) ? 'Укажите категорию' : '' ?></span>
        </div>
    </div>
    <div class="form__item form__item--wide<?=in_array('message', $errors) ? ' form__item--invalid' : '' ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота" required><?=$_POST['message'] ?? '' ?></textarea>
        <span class="form__error"><?=in_array('message', $errors) ? 'Проверьте, что поле заполнено' : '' ?></span>
    </div>
    <div class="form__item form__item--file<?=is_uploaded_file($_FILES['image']['tmp_name']) ? " form__item--uploaded" : ""; ?>"> <!--  -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" name="image" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small<?=in_array('lot-rate', $errors) ? ' form__item--invalid' : '' ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=$_POST['lot-rate'] ?? '' ?>" required>
            <span class="form__error"><?=in_array('lot-rate', $errors) ? 'Введите целое число' : '' ?></span>
        </div>
        <div class="form__item form__item--small<?=in_array('lot-step', $errors) ? ' form__item--invalid' : '' ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=$_POST['lot-step'] ?? '' ?>" required>
            <span class="form__error"><?=in_array('lot-step', $errors) ? 'Введите целое число' : '' ?></span>
        </div>
        <div class="form__item<?=in_array('lot-date', $errors) ? ' form__item--invalid' : '' ?>">
            <label for="lot-date">Дата завершения</label>
            <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" value="<?=$_POST['lot-date'] ?? '' ?>" required>
            <span class="form__error"><?=in_array('lot-date', $errors) ? 'Проверьте, что поле заполнено' : '' ?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
