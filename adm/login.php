<!DOCTYPE html>
<html>
<head>
    <title>관리자 로그인</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form action="login_process.php" method="POST">
        <h2>관리자 로그인</h2>
        <label for="username">사용자 이름:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">비밀번호:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">로그인</button>
    </form>
</body>
</html>
