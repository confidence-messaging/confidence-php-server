<?php

include 'db.php';

function postMessage($body)
{
    $pdo = getConnection();
    $from = $body['from'];
    $to = $body['to'];
    $message = $body['to'];
    $sql = "INSERT INTO messages (from, to, message) VALUES ('$from', '$to', '$message')";
    $sth = $pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return 'success';
}
