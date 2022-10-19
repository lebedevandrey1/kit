<?php
require_once '../db.php';

// Надо с БД взять имя пользователя
if($_COOKIE['login'])
{
    $res = $conn->query("SELECT * FROM user WHERE(`login` = '" . $_COOKIE['login'] . "') ");
    $user = $res->fetch_assoc();
}
?>

<div class="admin_line">
    <?php if(isset($user)):?>

        <div>
            <div class="authorize"><?=$user['name']?> | <a href="exit.php">Выход</a></div>
        </div>

    <?php endif?>
</div>
