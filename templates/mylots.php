<nav class="nav">
    <?=$categories_layout; ?>
</nav>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($bets as $bet): ?>
        <tr class="rates__item">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?=$bet['image_url']; ?>" width="54" height="40" alt="<?=strip_tags($bet['lot']); ?>">
                </div>
                <h3 class="rates__title"><a href="../lot.php?lot=<?=$bet['id'] ?>"><?=strip_tags($bet['lot']); ?></a></h3>
            </td>
            <td class="rates__category">
                <?=strip_tags($bet['category']); ?>
            </td>
            <td class="rates__timer">
                <div class="timer timer--finishing">
                    <?=date('z.H:i', strtotime($bet['lot_date']) - strtotime('now')); ?>
                </div>
            </td>
            <td class="rates__price">
                <?=strip_tags($bet['cost']); ?> р.
            </td>
            <td class="rates__time">
                <?=getRelativeDate($bet['bet_date']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>

