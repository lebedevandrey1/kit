<?php
require_once '../db.php';

// Получение массива данных вложенного каталога
function get_cat()
{
    // Доступ к подключению к БД
    global $conn;

    // Вытаскиваем из БД все записи
    $result = $conn->query("SELECT * FROM category");
    // Если вдруг в БД пусто, ничего на страницу не выводим. В идеале предупредить пользователя,
    // что записей нет
    if(!$result)
    {
        return NULL;
    }

    // Объявляем пустой массив, будем добавлять туда данные
    $arr_cat = array();
    // Если записи в БД есть, начинаем цикл
    if($result->num_rows != 0)
    {
        // Продолжаем цикл столько раз, сколько записей в БД
        for($i = 0; $i < $result->num_rows; $i++)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            // Формируем массив, смотря на id родительских элементов
            if(empty($arr_cat[$row['parent_id']]))
            {
                $arr_cat[$row['parent_id']] = array();
            }
            $arr_cat[$row['parent_id']][] = $row;
        }

        // После выполнения всех манипуляций возвращаем объявленный массив
        return $arr_cat;
    }
}


// Вывод каталога со всеми вложениями
function view_cat($arr,$parent_id = 0,$admin = TRUE)
{
    // Выход из рекурсии
    if(empty($arr[$parent_id]))
    {
        return;
    }

    // Начинаем визуальное построенние дерева

    echo '<ul>';

    // Переборка массива в цикле
    for($i = 0; $i < count($arr[$parent_id]); $i++)
    {
        echo '<li>'.$arr[$parent_id][$i]['title'].'<a href="edit.php?id='.$arr[$parent_id][$i]['id'].'">&#9998;</a>
                    <a href="del.php?id='.$arr[$parent_id][$i]['id'].'">&#10060;</a>
                    <a class="add_title" href="add.php?id='.$arr[$parent_id][$i]['id'].'">+</a>
                    <div>'.$arr[$parent_id][$i]['description'].'</div>';
        //рекурсия - проверяем нет ли дочерних категорий
        view_cat($arr,$arr[$parent_id][$i]['id']);
        echo '</li>';
    }

    echo '</ul>';
}


// Вывод категории для редактирования
function edit($id)
{
    // Страхуемся от ошибочно переданного значения
    if($id == 0 OR $id == '')
    {
        echo "Ошибка чтения записи!";
    }
    else
    {
        // Доступ к подключению к БД
        global $conn;

        // Вытаскиваем из БД все записи
        $result = $conn->query("SELECT * FROM category WHERE(`id` = '" . $id . "') ");
        // Если записей нет, отправляем пользователю ошибку
        if($result->num_rows == 0)
        {
            return "Выбрана неверная запись!";
        }
        else
        {
            return $result->fetch_assoc();
        }
    }
}


// Редактирование записи
function edit_cat($post)
{
    // Доступ к подключению к БД
    global $conn;

    // Вытаскиваем из БД все записи
    $result = $conn->query("SELECT * FROM category WHERE(`id` = '" . $post['id'] . "') ");
    // Страхуемся от кодовых инъекций (примитивно). Если записей по переданному id нет...
    if($result->num_rows == 0)
    {
        // Отправляем пользователя обратно на странице редактирования
        $_SESSION['flash'] = "Ошибка при редактировании записи!";
        header('Location: edit.php?'.$post['page']);
    }
    else
    {
        // В другом случае редактируем запись
        $result = $conn->query("UPDATE category SET 
                                        title = '" . $post['title'] . "',  
                                        description = '" . $post['description'] . "', 
                                        parent_id = '" . $post['parent_id'] . "' 
                                        WHERE(`id` = '" . $post['id'] . "') ");
        // И отправляем пользователя на страницу записей
        $_SESSION['flash'] = "Запись успешно отредактирована!";
        header('Location: structure.php');
    }
}


// Добавление записи
function add_cat($post)
{
    // Доступ к подключению к БД
    global $conn;
    $result = $conn->query("INSERT INTO category (title,description,parent_id) 
                                    VALUES ('".$post['title']."', '".$post['description']."', '".$post['parent_id']."')");
    // И отправляем пользователя на страницу записей
    $_SESSION['flash'] = "Запись успешно добавлена!";
    header('Location: structure.php');
}


// Удаление записи
function del_cat($post)
{
    // Доступ к подключению к БД
    global $conn;
    // Сначала удаляем все записи, в которых этот объект является родителем
    $conn->query("DELETE FROM category WHERE(`parent_id` = '" . $post['id'] . "') ");
    // А теперь удаляем сам объект
    $conn->query("DELETE FROM category WHERE(`id` = '" . $post['id'] . "') ");
    // И отправляем пользователя на страницу записей
    $_SESSION['flash'] = "Запись успешно удалена!";
    header('Location: structure.php');
}