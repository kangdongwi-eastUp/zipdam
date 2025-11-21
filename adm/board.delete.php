<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("잘못된 요청입니다.");
}

$id = intval($_GET['id']);

// 게시글 정보 가져오기
$result = $mysqli->query("SELECT * FROM board_news WHERE id = $id");
if ($result->num_rows === 0) {
    die("삭제할 게시글이 존재하지 않습니다.");
}

$row = $result->fetch_assoc();
$file_path = $row['file_path'];

// 첨부파일 삭제
if (!empty($file_path) && file_exists($file_path)) {
    if (!unlink($file_path)) {
        die("첨부파일 삭제 실패: " . htmlspecialchars($file_path));
    }
}

// 게시글 삭제
$sql = "DELETE FROM board_news WHERE id = $id";
if ($mysqli->query($sql)) {
    header("Location: board.php");
    exit;
} else {
    echo "게시글 삭제 중 오류가 발생했습니다: " . $mysqli->error;
}
?>
