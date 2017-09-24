<?php ?>

<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $key => $value): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$value['title']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($bets as $bet): ?>
        <tr class="rates__item">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?=$bet['image_url']; ?>" width="54" height="40" alt="<?=$bet['lot']; ?>">
                </div>
                <h3 class="rates__title"><a href="../lot.php?lot=<?=$bet['id'] ?>"><?=$bet['lot']; ?></a></h3>
            </td>
            <td class="rates__category">
                <?=$bet['category']; ?>
            </td>
            <td class="rates__timer">
                <div class="timer timer--finishing">
                    <?=date('z д. H ч. i м.', strtotime($bet['lot_date']) - strtotime('now')); ?>
                </div>
            </td>
            <td class="rates__price">
                <?=$bet['cost']; ?> р.
            </td>
            <td class="rates__time">
                <?=getRelativeDate(strtotime($bet['bet_date'])); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>

