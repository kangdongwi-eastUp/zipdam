<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.php'; // PDO connection

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user_id = $_SESSION['user_id'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "모든 필드를 입력해주세요.";
    } elseif ($new_password !== $confirm_password) {
        $error = "새 비밀번호가 일치하지 않습니다.";
    } elseif (strlen($new_password) < 8 || !preg_match('/[a-zA-Z]/', $new_password) || !preg_match('/[0-9]/', $new_password) || !preg_match('/[\W_]/', $new_password)) {
        $error = "비밀번호는 8자 이상이어야 하며, 영문, 숫자, 특수문자를 모두 포함해야 합니다.";
    } else {
        try {
            // 현재 비밀번호 확인
            $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id");
            $stmt->execute([':id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($current_password, $user['password_hash'])) {
                // 새 비밀번호 해시 생성 및 업데이트
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :id");
                if ($update_stmt->execute([':password_hash' => $new_password_hash, ':id' => $user_id])) {
                    echo "<script>
                            alert('비밀번호가 변경되었습니다. 새로 로그인해주세요.');
                            location.href = 'logout.php';
                          </script>";
                    exit;
                } else {
                    $error = "비밀번호 변경 중 오류가 발생했습니다.";
                }
            } else {
                $error = "현재 비밀번호가 올바르지 않습니다.";
            }
        } catch (PDOException $e) {
            $error = "데이터베이스 오류: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>집담 관리자 페이지 - 비밀번호 변경</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .message { color: green; }
        .error { color: red; }
        /* 페이지 중앙 정렬 */
        .content {
            display: flex;
            justify-content: center; /* 수평 중앙 정렬 */
            align-items: center; /* 수직 중앙 정렬 */
        }
    </style>
</head>
<body>
    <button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
    <div class="container">
        <?php include 'inc.nav.php'; ?>
        <div class="content">
            <div style="width: 400px;">

            <?php if ($message): ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <h2>비밀번호 변경</h2>
            <form action="password.php" method="POST">
                <div class="form-group">
                    <label for="current_password">현재 비밀번호:</label>
                    <input type="password" name="current_password" id="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">새 비밀번호:</label>
                    <input type="password" name="new_password" id="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">새 비밀번호 확인:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>
                <button type="submit">비밀번호 변경</button>
            </form>
            </div>
        </div>
    </div>
    <script>
        // This script is from adm/index.php for menu toggling
        const toggleButton = document.querySelector('.menu-toggle');
        const nav = document.querySelector('nav');
        function adjustNav() { if (window.innerWidth > 768) { nav.classList.remove('hidden'); nav.classList.add('visible'); } else { nav.classList.add('hidden'); nav.classList.remove('visible'); } }
        toggleButton.addEventListener('click', () => { nav.classList.toggle('hidden'); nav.classList.toggle('visible'); });
        window.addEventListener('resize', adjustNav);
        adjustNav();
    </script>
</body>
</html>