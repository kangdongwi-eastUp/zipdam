<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

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
    'agreement,approval' => '입주민동의서 + 행위허가'
];

$item_counts = [];

foreach ($items as $key => $label) {
    $result = $mysqli->query("SELECT COUNT(*) AS count FROM request WHERE deleted = 'n' AND items = '$key' ");
    $row = $result->fetch_assoc();
    $item_counts[$key] = $row['count']; // 해당 아이템의 개수 저장
}
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
            <h2>서비스신청 관리 <button type="button" onClick="location.href='request.deleted.php'"><i class="fa-solid fa-recycle"></i></button></h2>

            <ul>
                <?php foreach ($items as $key => $label): ?>
                    <?php if ($item_counts[$key] > 0) $item_count_prnt = "<span>".$item_counts[$key]."</span>"; else $item_count_prnt = "";?>

                    <li><div><?= $label ?> <?=$item_count_prnt?></div>
                        <button type="button" onClick="location.href='request.list.php?type=<?=$key?>'"><i class="fa-regular fa-file-lines"></i></button>
                    </li>
                <?php endforeach; ?>
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
