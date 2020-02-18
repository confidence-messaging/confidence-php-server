<?php

include 'config.php';

$message = array('version' => $_PRIV8MESSAGING['version'], 'name' => $_PRIV8MESSAGING['name'], 'address' => $_PRIV8MESSAGING['address'], 'message' => $_PRIV8MESSAGING['message'], 'contact' => $_PRIV8MESSAGING['contact'], 'messages' => 0);

echo json_encode($message);
