<?php

require 'app.php';

/**
 * Función para incluir un archivo.php del directorio template
 */

function include_template(string $nombre, bool $isShow = true)
{
    include TEMPLATE_URL . "/${nombre}.php";
}
/**
 * Función para Depurar el codigo deteniendo la ejecución del mismo
 */

function dd($debug)
{
    echo '<pre>';
    var_dump($debug);
    echo '</pre>';
    die;
}

/**
 * Función para Depurar el codigo sin detener la ejecución del mismo
 */

function d($debug)
{
    echo '<pre>';
    var_dump($debug);
    echo '</pre>';
}
