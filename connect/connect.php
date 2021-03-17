<?php
require_once('./settings.php');

ob_start();
session_start();

$conn = new PDO(
    sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s;',
        $setting['host'],
        $setting['port'],
        $setting['dbName'],
        $setting['charset']
    ),
        $setting['username'],
        $setting['password']
);

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(Exception $e) {
    echo 'Connection failed'.$e->getMessage();
    exit();
}