<nav class="nav">
    <?=$categories_layout; ?>
</nav>
<div class="container">
    <section class="lots">
        <h2>Все лоты в категории «<span><?=$cat['title']; ?>»</span></h2>
        <ul class="lots__list">
            <?php foreach ($goods as $i => $it): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?=$it['image_url']; ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?=$it['cat_title']; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?lot=<?=$it['id'] ?>"><?=strip_tags($it['title']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?=strip_tags($it['price']); ?><b class="rub">р</b></span>
                            </div>
                            <div class="lot__timer timer">
                                <?=date('z. H:i', strtotime(strip_tags($it['finished_at'])) - strtotime('now')); ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</div>
