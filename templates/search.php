<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $i => $it): ?>
        <li class="nav__item">
            <a href="all-lots.php?cat=<?=$value['id']; ?>"><?=$value['title']; ?>"><?=$it['title']; ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?=$query; ?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($goods as $i => $it): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?=$it['image_url']; ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?=$it['cat_title']; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?lot=<?=$it['id'] ?>"><?=htmlspecialchars($it['title']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?=htmlspecialchars($it['price']); ?><b class="rub">р</b></span>
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
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>
