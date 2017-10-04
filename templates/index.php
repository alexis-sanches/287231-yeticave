<?php ?>

<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $i => $it): ?>
        <li class="promo__item promo__item--<?=$it['id']; ?>">
            <a class="promo__link" href="all-lots.php?cat=<?=$it['id']; ?>"><?=strip_tags($it['title']); ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
        <select class="lots__select">
            <?php foreach ($categories as $i => $it): ?>
                <option><?=strip_tags($it['title']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <ul class="lots__list">
        <?php foreach ($goods as $i => $it): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$it['image_url']; ?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=strip_tags($it['cat_title']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?lot=<?=$it['id'] ?>"><?=strip_tags($it['title']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=strip_tags($it['price']); ?><b class="rub">р</b></span>
                        </div>
                        <div class="lot__timer timer">
                            <?=date('z. H:i', strtotime($it['finished_at']) - strtotime('now')); ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php if ($total_items > $limit): ?>
<ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a<?=$page == 1 ? '' : ' href="?page=' . ($page - 1) . '"'?>>Назад</a></li>
    <?php foreach ($range as $value): ?>
        <li class="pagination-item<?=$page == $value ? ' pagination-item-active' : ''; ?>"><a href="?page=<?=$value; ?>"><?=$value; ?></a></li>
    <?php endforeach; ?>
    <li class="pagination-item pagination-item-next">
        <a<?=$page == count($range) ? '' : ' href="?page=' . ($page + 1) . '"'?>>Вперед</a></li>
</ul>
<?php endif; ?>
