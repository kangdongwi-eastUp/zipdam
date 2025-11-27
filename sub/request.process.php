<?php
include '../adm/inc.db.php';
include '../vendor/autoload.php';
include '../adm/inc.config.php';

use Nurigo\Solapi\Models\Message;
use Nurigo\Solapi\Services\SolapiMessageService;
use Nurigo\Solapi\Models\Kakao\KakaoOption;

$fields = [
    'items', 'consent01', 'consent02', 'consent03', 'date_prnt', 'address', 'detailAddress', 
    'name', 'phone', 'type', 'company', 'poc', 'poc_name', 'poc_phone', 'residence', 
    'residence_name', 'residence_phone', 'construction', 'construction_etc', 'date_noise', 
    'curing', 'curing_etc', 'status', 'object', 'object_etc', 'zipdam_approval', 'door_product', 
    'remove_object', 'space_type', 'space_size', 'payment_method', 'check_confirm', 'check_alrim',
    'other_service_option', 'mang_type', 'mang_option', 'waste_option', 'waste_content'
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

// 🔔 카카오 알림톡 발송
$messageService = new SolapiMessageService(SOLAPI_API_KEY, SOLAPI_API_SECRET);

$kakaoOption = new KakaoOption();
$kakaoOption->setPfId(KAKAO_PF_ID)
            ->setTemplateId(KAKAO_TEMPLATE_ID_REQUEST);

$message = new Message();
$message->setTo($data['phone'])
        ->setKakaoOptions($kakaoOption);

// 실제 발송 처리 (에러 처리를 위해 try-catch 사용)
try {
    $messageService->send($message);
} catch (Exception $e) {
    // 발송 실패 시 에러를 기록하거나 다른 처리를 할 수 있습니다.
    error_log($e->getMessage());
}

echo "<script>location.href='request.complete.php';</script>";
exit;

// ✅ 에러 메시지 출력 후 리디렉션하는 함수
function alertAndRedirect($message, $redirectPage) {
    echo "<script>alert('$message'); location.href='$redirectPage';</script>";
}
?>