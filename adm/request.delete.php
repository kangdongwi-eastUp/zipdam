<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

$id = $_GET['id'] ?? '';

if (!empty($id) && is_numeric($id)) {
    // id 값이 숫자인지 확인하여 SQL 인젝션 방지
    $stmt = $mysqli->prepare("UPDATE request SET deleted = 'y', del_date = NOW() WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $message = "삭제 상태로 변경되었습니다.";
    } else {
        $message = "업데이트 실패: " . $mysqli->error;
    }
    
    $stmt->close();
} else {
    $message = "유효하지 않은 ID 값입니다.";
}

$mysqli->close();
echo "<script>alert('$message'); location.href='request.php';</script>";
?>
