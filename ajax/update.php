<?php
include("../sys/db.php");

$db->beginTransaction();
$ex = $db->prepare("UPDATE " . $_POST['table'] . " SET " . $_POST['values']['set'] . " = :value WHERE " . $_POST['key']['key'] . " = :id");
$ex->execute([
    'id' => $_POST['key']['value'],
    "value" => $_POST['values']['value']
]);

if ($ex->rowCount()) {
    $db->commit();
    echo "Başarılı!";
} else {
    $db->rollBack();
    echo "Başarısız!";
}
