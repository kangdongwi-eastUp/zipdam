<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

$type = $_GET['type'] ?? '';
$result = $mysqli->query("SELECT * FROM request WHERE items = '{$type}' AND deleted = 'n' ");
$items = [
    'agreement' => '입주민동의서',
    'curing' => '보양',
    'approval' => '행위허가',
    'door' => '방화문,유리,문',
    'remove' => '보양탈거',
    'cleaning' => '입주청소',
    'agreement,curing' => '입주민동의서 + 보양',
    'curing,approval' => '보양 + 행위허가',
    'agreement,curing,approval' => '입주민동의서 + 보양 + 행위허가',
    'agreement,approval' => '입주민동의서 + 행위허가',
    'appForUse' => '사용검사',
    'installScreen' => '방충망시공',
    'wasteCollection' => '폐기물수거'
];

$item_label = $items[$type] ?? '알 수 없는 항목';
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>집담 관리자 페이지</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/request.css">
</head>
<body>
    <button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
    <div class="container">
        <?php include 'inc.nav.php'; ?>
        <div class="content">
            <h2><button type="button" onClick="location.href='request.php'"><i class="fa-solid fa-list"></i></button> <span>서비스신청 관리 - </span><?=$item_label?></h2>

            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <div>
                            <?=$row['name']?>
                            <?=$row['phone']?>
                            <?= date('Y-m-d', strtotime($row['reg_date'])) ?>
                        </div>
                        <div>
                            <button type="button" onClick="location.href='request.detail.php?id=<?=$row['id']?>'"><i class="fa-solid fa-clipboard"></i></button>
                            <button type="button" onClick="location.href='request.delete.php?id=<?=$row['id']?>'"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
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
