<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

// 초기화
$title = '';
$content = '';
$file_path = '';
$author = htmlspecialchars($_SESSION['nick']);
$is_edit = false;

// 수정 모드일 경우
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $mysqli->query("SELECT * FROM board_news WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $file_path = $row['file_path'];
        $author = $row['author'];
        $is_edit = true;
    } else {
        die("존재하지 않는 게시글입니다.");
    }
}

// 저장 또는 수정 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $title = $mysqli->real_escape_string($_POST['title']);
    $content = $mysqli->real_escape_string($_POST['content']);
    $author = $mysqli->real_escape_string($_POST['author']);
    
    // 파일 업로드 처리
    if (!empty($_FILES['file']['name'])) {
        $original_file_name = basename($_FILES['file']['name']); // 원본 파일명
        $file_extension = pathinfo($original_file_name, PATHINFO_EXTENSION); // 파일 확장자 추출
        $unique_file_name = time() . '_' . uniqid() . '.' . $file_extension; // 고유한 파일명 생성
        $upload_dir = realpath(__DIR__ . '/../uploads') . '/';
        $file_path = $upload_dir . $unique_file_name;

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            die("파일 업로드 실패. tmp_name: {$_FILES['file']['tmp_name']} -> file_path: {$file_path}");
        }
    }

    // 수정 모드
    if ($is_edit) {
        $sql = "UPDATE board_news SET 
                    title = '$title', 
                    content = '$content', 
                    file_path = '$file_path', 
                    author = '$author' 
                WHERE id = $id";
    } else {
        // 새 게시글 저장
        $sql = "INSERT INTO board_news (title, content, file_path, author) VALUES ('$title', '$content', '$file_path', '$author')";
    }

    if ($mysqli->query($sql)) {
        header("Location: board.php");
        exit;
    } else {
        echo "글 저장 중 오류가 발생했습니다: " . $mysqli->error;
    }
}
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
            <h2>소식 관리 - <?= $is_edit ? '수정' : '새글 작성' ?></h2>
            <form action="board.write.php<?= $is_edit ? '?id=' . $id : '' ?>" method="post" enctype="multipart/form-data">
                <?php if ($is_edit): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>
                <input type="hidden" name="author" value="<?= htmlspecialchars($author) ?>">
                <label><input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required placeholder="제목"></label><br>
                <label><textarea name="content" rows="10" cols="50" required placeholder="내용"><?= htmlspecialchars($content) ?></textarea></label><br>
                <label><input type="file" name="file"></label>
                <?php if ($file_path): ?>
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
                        <p class="desc">현재 첨부 이미지:</p>
                        <img src="<?= htmlspecialchars($web_path) ?>" alt="첨부 이미지">
                    <?php else: ?>
                        <p class="desc">현재 첨부파일: <a href="<?= htmlspecialchars($web_path) ?>" download><?= htmlspecialchars($file_name_prnt) ?></a></p>
                    <?php endif; ?>
                <?php endif; ?>
                <br>
                <a href="board.php" class="a_btn">목록으로</a> 
                <button type="submit" class="a_btn"><?= $is_edit ? '수정' : '저장' ?></button>
            </form>
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
