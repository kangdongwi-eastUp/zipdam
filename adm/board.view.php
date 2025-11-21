<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

$id = intval($_GET['id']);
$result = $mysqli->query("SELECT * FROM board_news WHERE id = $id");

if ($result->num_rows == 0) {
    die("해당 게시글이 존재하지 않습니다.");
}

$row = $result->fetch_assoc();
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
            <div class="board-view">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p class="desc"><?= htmlspecialchars($row['author']) ?> | <?= $row['created_at'] ?></p>
                <hr>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <?php if ($row['file_path']): ?>
                    <?php 
                        // 절대 경로를 웹 경로로 변환
                        $web_path = str_replace('/zipdam2020/www', '', $row['file_path']);
                        $file_name_prnt = str_replace('/zipdam2020/www/uploads/', '', $row['file_path']);

                        // 파일 확장자 추출
                        $file_extension = pathinfo($row['file_path'], PATHINFO_EXTENSION);
                        // 이미지 확장자 목록
                        $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                    ?>
                    <?php if (in_array(strtolower($file_extension), $image_extensions)): ?>
                        <p class="desc">첨부 이미지:</p>
                        <img src="<?= htmlspecialchars($web_path) ?>" alt="첨부 이미지">
                    <?php else: ?>
                        <p class="desc">첨부파일: <a href="<?= htmlspecialchars($web_path) ?>" download><?= htmlspecialchars($file_name_prnt) ?></a></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="btns">
                <a href="board.delete.php?id=<?= $id ?>" class="a_btn" onclick="return confirm('정말로 삭제하시겠습니까?');">삭제</a>
                <a href="board.write.php?id=<?= $id ?>" class="a_btn">수정</a>
                <a href="board.php" class="a_btn">목록으로</a>
            </div>
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
