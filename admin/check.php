<?php
session_start();

require_once '../db.php';

// Удаляем всё лишнее из переменных
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

// Первоочередные проверки от детских шалостей, чтобы перейти к более серьезной безопасности
// В логине могут быть только основные символы
if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
{
    $_SESSION['flash'] = "Логин может состоять только из букв английского алфавита и цифр";
    header('Location: index.php');
    return;
}
else
{
    // Также логин не может быть менее 3 и более 30 символов
    if(strlen($login) < 3 OR strlen($login) > 30)
    {
        $_SESSION['flash'] = "Логин должен быть не меньше 3-х символов и не больше 30";
        header('Location: index.php');
        return;
    }
}


// Я бы предпочёл собрать все ошибки пользователя в один массив, типа $error = array(), но это
// более сложная реализация. Поэтому ошибки будем выводить по 1 штуке через flash

// Несмотря на проверку пустых полей на странице авторизации, делаем защиту и в самом скрипте
if($login != "" && $pass != "")
{
    // Сначала проверяем пользователя по логину, существует ли он
    $result = $conn->query("SELECT login,pass FROM user WHERE(`login` = '" . $login . "') ");
    // Если пользователь существует, идем дальше
    if ($result->num_rows == 1)
    {
        // Извлекаем строку с данными из БД
        $row = $result->fetch_assoc();
        // Теперь сравниваем хэш имеющегося пароля с тем, что прислал пользователь. Если совпадает, авторизуем
        if (password_verify($pass, $row['pass']))
        {
            //пишутся логин и хэшированный пароль в cookie, также создаётся переменная сессии
            setcookie ("login", $row['login'], time() + 50000);
            setcookie ("password", md5($row['login'].$row['pass']), time() + 50000);
            // Записываем пользователя в сессию
            $_SESSION['id'] = $row['id'];

            // Здесь я бы еще обязательно сделал запись в БД, что такой-то пользователь авторизовался

            // Переадресуем человека в админку
            header('Location: structure.php');
        }
        else
        {
            $_SESSION['flash'] = "Неверный пароль";
            header('Location: index.php');
        }
    }
    else
    {
        $_SESSION['flash'] = "Пользователя не существует";
        header('Location: index.php');
    }
}
else
{
    $_SESSION['flash'] = "Поля не должны быть пустыми";
    header('Location: index.php');
}

return;


