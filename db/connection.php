<?php

function getConnection()
{
    include 'config.php';
    $pdo = new PDO('mysql:host=' . $_PRIV8MESSAGING['DB_HOST'] . ';dbname=' . $_PRIV8MESSAGING['DB_NAME'], $_PRIV8MESSAGING['DB_USER'], $_PRIV8MESSAGING['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

    return $pdo;
}
