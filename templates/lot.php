<?php ?>
<nav class="nav">
    <ul class="nav__list container">
        <li class="nav__item">
            <a href="">Доски и лыжи</a>
        </li>
        <li class="nav__item">
            <a href="">Крепления</a>
        </li>
        <li class="nav__item">
            <a href="">Ботинки</a>
        </li>
        <li class="nav__item">
            <a href="">Одежда</a>
        </li>
        <li class="nav__item">
            <a href="">Инструменты</a>
        </li>
        <li class="nav__item">
            <a href="">Разное</a>
        </li>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?=$lot['title']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot['image_url']; ?>" width="730" height="548" alt="<?=$lot['title']; ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['category']; ?></span></p>
            <p class="lot-item__description"><?=$lot['description']; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54:12
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$lot['price']; ?> р.</span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span>12 000 р</span>
                    </div>
                </div>
                <?php if (isset($_SESSION['user']) && !isset($_COOKIE['bet'.$id])): ?>

                <form class="lot-item__form" novalidate action="" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" required placeholder="12 000">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
                <?php endif; ?>

            </div>
            <div class="history">
                <h3>История ставок (<span><?=count($bets); ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bets as $key => $value): ?>
                        <tr class="history__item">
                            <td class="history__name"><?=$value['name'] ?></td>
                            <td class="history__price"><?=$value['price'] ?> р</td>
                            <td class="history__time"><?=getRelativeDate($value['ts']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
