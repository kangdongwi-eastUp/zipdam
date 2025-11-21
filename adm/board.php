<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

$result = $mysqli->query("SELECT id, title, author, created_at FROM board_news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>집담 관리자 페이지</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/board.css">
</head>
<body>
    <button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
    <div class="container">
        <?php include 'inc.nav.php'; ?>
        <div class="content">
            <h2>소식 관리</h2>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>제목</th>
                        <th>작성자</th>
                        <th>작성일시</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><a href="board.view.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= $row['created_at'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="board.write.php" class="a_btn">새글작성</a>
        </div>
    </div>
    <script>
        const toggleButton = document.querySelector('.menu-toggle');
        const nav = document.querySelector('nav');

        // 초기 화면 크기에 따라 메뉴 상태 설정
        function adjustNav() {
            if (window.innerWidth > 768) {
                nav.classList.remove('hidden');
                nav.classList.add('visible');
            } else {
                nav.classList.add('hidden');
                nav.classList.remove('visible');
            }
        }

        // 메뉴 토글 버튼 클릭 이벤트
        toggleButton.addEventListener('click', () => {
            nav.classList.toggle('hidden');
            nav.classList.toggle('visible');
        });

        // 창 크기 조정 이벤트
        window.addEventListener('resize', adjustNav);

        // 페이지 로드 시 초기 메뉴 상태 설정
        adjustNav();
    </script>
</body>
</html>
