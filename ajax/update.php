<?php
include("../sys/db.php");

header('Content-Type: application/json');

$db->beginTransaction();

$ex = $db->prepare("UPDATE " . $_POST['table'] . " SET " . $_POST['values']['set'] . " = :value WHERE " . $_POST['key']['key'] . " = :id");

$ex->execute([
    'id' => $_POST['key']['value'],
    "value" => $_POST['values']['value']
]);

$return['response'] = 0;

if ($ex->rowCount()) {
    $db->commit();
    $return['response'] = 1;
} else {
    $db->rollBack();
}

echo json_encode($return, JSON_UNESCAPED_UNICODE);