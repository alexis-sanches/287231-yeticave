<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?=strip_tags($username) ?></p>
<p>Ваша ставка для лота <a href="<?=$_SERVER['HTTP_HOST'] . '/lot.php?lot=' . $id; ?>"><?=strip_tags($lot_name); ?></a> победила.</p>
<p>Перейдите по ссылке <a href="<?=$_SERVER['HTTP_HOST'];?>/mylots.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>

<small>Интернет Аукцион "YetiCave"</small>