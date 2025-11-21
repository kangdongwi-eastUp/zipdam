<?php
$pdo = new PDO('mysql:host=localhost;dbname=zipdam2020', 'zipdam2020', 'zip2020!');
$username = 'admin';
$password = 'zip2020##';

// 비밀번호 해시 생성
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 데이터베이스에 삽입
$stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
$stmt->execute([
    ':username' => $username,
    ':password_hash' => $hashed_password
]);

echo "사용자가 추가되었습니다.";
?>
