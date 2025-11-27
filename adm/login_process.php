<?php
session_start();

include 'inc.db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 사용자 정보 가져오기
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        // 로그인 성공
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nick'] = $user['nick'];
        echo "로그인 성공! 환영합니다, " . htmlspecialchars($user['username']);
        header("Location: index.php");
    } else {
        // 로그인 실패
        echo "<script>
            alert('잘못된 사용자 이름 또는 비밀번호입니다.');
            location.href = 'login.php';
        </script>";
    }
}
?>
