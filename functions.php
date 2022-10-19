<?php
require_once 'db.php';

// Распределение списка по иерархии
function convert($array, $i = 'id', $p = 'parent_id')
{
    if (!is_array($array))
    {
        return array();
    }
    else
    {
        $ids = array();
        foreach ($array as $k => $v)
        {
            if (is_array($v))
            {
                if ((isset($v[$i]) OR ($i == FALSE)) AND isset($v[$p]))
                {
                    $key = ($i == FALSE) ? $k : $v[$i];
                    $parent = $v[$p];
                    $ids[$parent][$key] = $v;
                }
            }
        }

        return (isset($ids[0])) ? convert_node($ids, 0, 'children') : FALSE;
    }
}


// Доп. функция для распределения списка по иерархии
function convert_node($index, $root, $cn)
{
    $_ret = array();
    foreach ($index[$root] as $k => $v)
    {
        $_ret[$k] = $v;
        if (isset($index[$k]))
        {
            $_ret[$k][$cn] = convert_node($index, $k, $cn);
        }
    }

    return $_ret;
}


// Вывод иерархии в виды
function out_tree_checkbox($array, $first = TRUE)
{
    $out = ($first) ? '<ul>' : '<ul>';

    foreach ($array as $row)
    {
        $out .= '<li><details><summary>';
        $out .= '<a href="index.php?show='.$row['id'].'">'.$row['title'].'</a></summary>';
        if (isset($row['children']))
        {
            $out .= out_tree_checkbox($row['children'], FALSE);
        }
        $out .= '</details></li>';
    }
    $out .= '</ul>';

    return $out;
}