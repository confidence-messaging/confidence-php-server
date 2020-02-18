<?php

function handleResponse($message)
{
    $res = array('success' => true, 'message' => $message);
    echo json_encode($res);
}
