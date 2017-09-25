<nav class="nav">
    <?=$categories_layout; ?>
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
                    <?=date('z.H:i', strtotime($lot['finished_at']) - strtotime('now')); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$lot['curr_price']; ?> р.</span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=$lot['min_price']; ?> р</span>
                    </div>
                </div>
                <?php if (isset($_SESSION['user'])): ?>
                <form class="lot-item__form<?=count($errors) ? ' form--invalid' : '' ?>" novalidate action="" method="post">
                    <p class="lot-item__form-item<?=in_array('cost', $errors) ? ' form__item--invalid' : '' ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" required placeholder="<?=$lot['min_price']; ?> ">
                        <span class="form__error"><?=in_array('cost', $errors) ? 'Ставка слишком маленькая' : '' ?></span>
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
                            <td class="history__name"><?=$value['user_name'] ?></td>
                            <td class="history__price"><?=$value['cost'] ?> р</td>
                            <td class="history__time"><?=getRelativeDate(strtotime($value['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
