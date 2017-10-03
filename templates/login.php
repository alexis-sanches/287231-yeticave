<nav class="nav">
    <?=$categories_layout; ?>
</nav>
<form class="form container<?=count($errors) > 0 ? ' form--invalid' : ''; ?>" action="login.php" enctype="application/x-www-form-urlencoded" method="post" novalidate> <!-- form--invalid -->
    <h2>Вход</h2>
    <?php if (isset($_GET['signup']) && $_GET['signup'] == 'true'): ?>
        <p>Теперь вы можете войти, используя свой email и пароль</p>
    <?php endif; ?>
    <div class="form__item<?=isset($errors['email']) ? ' form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=strip_tags($_POST['email']) ?? '' ?>" required>
        <span class="form__error"><?=isset($errors['email']) ? $errors['email'] : ''; ?></span>
    </div>
    <div class="form__item form__item--last<?=isset($errors['password']) ? ' form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" required>
        <span class="form__error"><?=isset($errors['password']) ? $errors['password'] : '' ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>

