<?php

function getDatabaseConnection() : PDO {
    $db = new PDO('sqlite:' . __DIR__ . '/mango.db');
    return $db;
}

?>