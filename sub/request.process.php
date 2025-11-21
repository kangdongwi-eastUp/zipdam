<?php
include '../adm/inc.db.php';
$fields = [
    'items', 'consent01', 'consent02', 'consent03', 'date_prnt', 'address', 'detailAddress', 
    'name', 'phone', 'type', 'company', 'poc', 'poc_name', 'poc_phone', 'residence', 
    'residence_name', 'residence_phone', 'construction', 'construction_etc', 'date_noise', 
    'curing', 'curing_etc', 'status', 'object', 'object_etc', 'zipdam_approval', 'door_product', 
    'remove_object', 'space_type', 'space_size', 'payment_method', 'check_confirm', 'check_alrim'
];
$data = [];
foreach ($fields as $field) {
    $data[$field] = isset($_POST[$field]) ? htmlspecialchars($_POST[$field], ENT_QUOTES, 'UTF-8') : null;
}
// ✅ 유효성 검사
if (empty($data['items'])) {
    alertAndRedirect("정상적인 접근이 아닙니다.", "request.php");
    exit;
}

$requiredYesFields = ['consent01', 'consent02', 'check_confirm', 'check_alrim'];
foreach ($requiredYesFields as $field) {
    if ($data[$field] !== 'y') {
        alertAndRedirect("동의되지 않은 항목이 있습니다.", "request.php");
        exit;
    }
}
$sql = "INSERT INTO request (" . implode(", ", $fields) . ", deleted , reg_date) 
        VALUES (" . implode(", ", array_fill(0, count($fields), "?")) . ",'n' , NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute(array_values($data));

echo "<script>location.href='request.complete.php';</script>";
exit;

// ✅ 에러 메시지 출력 후 리디렉션하는 함수
function alertAndRedirect($message, $redirectPage) {
    echo "<script>alert('$message'); location.href='$redirectPage';</script>";
}
?>