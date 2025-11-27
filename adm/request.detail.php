<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'inc.db.com.php';

$id = $_GET['id'] ?? '';
$result = $mysqli->query("SELECT * FROM request WHERE id = '{$id}' AND deleted = 'n' ");
$row = $result->fetch_assoc();
if (isset($row['items'])) {
    $itemArray = explode(',', $row['items']);
} else {
    $itemArray = [];
}

switch ($row['items']) {
    case 'agreement':
        $item_label = '입주민동의서';
        break;
    case 'curing':
        $item_label = '보양';
        break;
    case 'approval':
        $item_label = '행위허가';
        break;
    case 'door':
        $item_label = '방화문,유리,문';
        break;
    case 'remove':
        $item_label = '보양탈거';
        break;
    case 'cleaning':
        $item_label = '입주청소';
        break;
    case 'agreement,curing':
        $item_label = '입주민동의서 + 보양';
        break;
    case 'curing,approval':
        $item_label = '보양 + 행위허가';
        break;
    case 'agreement,curing,approval':
        $item_label = '입주민동의서 + 보양 + 행위허가';
        break;
    case 'agreement,approval':
        $item_label = '입주민동의서 + 행위허가';
        break;
    case 'appForUse':
        $item_label = '사용검사';
        break;
    default:
        $item_label = '알 수 없는 항목';
        break;
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
            <h2><button type="button" onClick="location.href='request.php'"><i class="fa-solid fa-list"></i></button> <span>서비스신청 관리 - </span><?=$item_label?></h2>

            <ul>
                <li>
                    <div>
                        <?=$row['name']?>
                        <?=$row['phone']?>
                        <?= date('Y-m-d', strtotime($row['reg_date'])) ?>
                    </div>
                    <button type="button" onClick="history.back();"><i class="fa-solid fa-trash-can"></i></button>
                </li>
            </ul>
            <div class="content">
                <?php
                    //변수정리
                    $date_begin = isset($row['date_begin']) ? $row['date_begin'] : null;
                    $date_end = isset($row['date_end']) ? $row['date_end'] : null;
                    $formatted_begin = date('Y년 m월 d일', strtotime($date_begin));
                    $formatted_end = date('Y년 m월 d일', strtotime($date_end));
                ?>

                <!--선택A-->
                <?php 
                if (in_array('agreement', $itemArray)||in_array('approval', $itemArray)):?>
                    <div class="data-group">
                        <span class="date_begin">공사 기간을 입력해 주세요. </span>
                        <?php $date_prnt = "{$formatted_begin} 부터 {$formatted_end} 까지"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php elseif (in_array('curing', $itemArray)): ?>
                    <div class="data-group">
                        <span class="date_begin">공사 시작일 또는 시공희망일을 선택해 주세요.</span>
                        <?php $date_prnt = "{$formatted_begin}"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php elseif (in_array('door', $itemArray)): ?>
                    <div class="data-group">
                        <span class="date_begin">시공 희망일 또는 예상일을 입력해주세요. </span>
                        <?php $date_prnt = "{$formatted_begin}"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php elseif (in_array('remove', $itemArray)): ?>
                    <div class="data-group">
                        <span class="date_begin">보양 탈거 희망일 또는 예상일을 입력해주세요. </span>
                        <?php $date_prnt = "{$formatted_begin}"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php elseif (in_array('cleaning', $itemArray)): ?>
                    <div class="data-group">
                        <span class="date_begin">입주청소 희망일을 선택해 주세요.</span>
                        <?php $date_prnt = "{$formatted_begin}"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php elseif (in_array('appForUse', $itemArray)): ?>
                    <div class="data-group">
                        <span class="date_begin">검사 희망일을 선택해 주세요.</span>
                        <?php $date_prnt = "{$formatted_begin}"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php elseif (in_array('installScreen', $itemArray)): ?>
                    <div class="data-group">
                        <span class="date_begin">시공 희망일을 선택해 주세요.</span>
                        <?php $date_prnt = "{$formatted_begin}"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php elseif (in_array('wasteCollection', $itemArray)): ?>
                    <div class="data-group">
                        <span class="date_begin">수거 희망일을 선택해 주세요.</span>
                        <?php $date_prnt = "{$formatted_begin}"; ?>
                        <?= $date_prnt ?>
                    </div>
                <?php endif; ?>
                
                <!--공통A-->
                <div class="data-group">
                    <span class="address">현장 주소를 입력해 주세요.</span>
                    <?= $row['address'] ?> <?= $row['detailAddress'] ?>
                </div>
                <div class="data-group">
                    <span class="name">신청인명과 연락처를 입력해 주세요.</span>
                    <?= $row['name'] ?> <?= $row['phone'] ?>
                </div>
                <div class="data-group">
                    <span class="type">신청인이 개인 또는 업체 이실까요?</span>
                    <?= $row['type'] ?>
                    <?php if ($row['type'] == '업체 (공사 업체)'): ?>
                        <?= $row['company'] ?>
                    <?php endif; ?>
                </div>

                <!--선택B-->
                <?php if (in_array('agreement', $itemArray)||in_array('approval', $itemArray)):?>
                    <div class="data-group">
                        <span class="address">현장 담당자명과 연락처를 작성해 주세요. </span>
                        <?= $row['poc'] ?>
                        <?php if ($row['poc'] == '다른분이 있어요.'): ?>
                            <?= $row['poc_name'] ?> <?= $row['poc_phone'] ?>
                        <?php endif; ?>
                    </div>
                    <div class="data-group">
                        <span class="residence">입주자의 성명과 연락처를 작성해 주세요. </span>
                        <?= $row['residence'] ?>
                        <?php if ($row['residence'] == '다른분이 있어요.'): ?>
                            <?= $row['residence_name'] ?>
                            <?= $row['residence_phone'] ?>
                        <?php endif; ?>
                    </div>                                         
                <?php endif; ?>

                <!--개별-->
                <?php if (in_array('agreement', $itemArray)):?>
                    <div class="data-group">
                        <span class="construction">공사내용을 선택해 주세요. </span>
                        <?= $row['construction'] ?>
                        <?php if ($row['construction'] == '기타'): ?>
                            <?= $row['construction_etc'] ?>
                        <?php endif; ?>
                    </div>
                    <div class="data-group">
                        <span class="date_noise">공사중 소음이 집중되는 예상일은 언제일까요? </span>
                        <?= $row['date_noise'] ?>
                    </div>
                <?php endif; ?>
                <?php if (in_array('curing', $itemArray)):?>
                    <div class="data-group">
                        <span class="curing">원하시는 보양 유형을 선택해 주세요. </span>
                        <?php $curing = explode(', ', $row['curing']); ?>
                        <?php echo $row['curing'] ?>
                        <?php if (in_array('기타', $curing)): ?>
                            <?= $row['curing_etc'] ?>
                        <?php endif; ?>
                    </div>                        
                <?php endif; ?>
                <?php if (in_array('approval', $itemArray)):?>
                    <div class="data-group">
                        <span class="status">현장의 상태를 선택해 주세요. </span>
                        <?= $row['status'] ?>
                    </div>                  
                    <div class="data-group">
                        <span class="object">계획하신 행위허가 대상을 선택해 주세요. </span>
                        <?= $row['object'] ?>
                        <?php if ($row['object'] == '기타'): ?>
                            <?= $row['object_etc'] ?>
                        <?php endif; ?>
                    </div>                                     
                <?php endif; ?>
                <?php if (in_array('door', $itemArray)):?>
                    <div class="data-group">
                        <span class="zipdam_approval">집담에서 행위허가를 진행 하셨나요? </span>
                        <?= $row['zipdam_approval'] ?>
                    </div>     
                    <div class="data-group">
                        <span class="door_product">의뢰하실 품목을 모두 선택해 주세요. </span>
                        <?= $row['door_product'] ?>
                    </div>                             
                <?php endif; ?>
                <?php if (in_array('remove', $itemArray)):?>
                    <div class="data-group">
                        <span class="remove_object">탈거할 보양 유형을 선택해주세요. </span>
                        <?= $row['remove_object'] ?>
                    </div>   
                <?php endif; ?>
                <?php if (in_array('cleaning', $itemArray)):?>
                    <div class="data-group">
                        <span class="space_type">현장의 공간 유형을 선택해 주세요. </span>
                        <?= $row['space_type'] ?>
                    </div>        
                    <div class="data-group">
                        <span class="space_size">공간의 실 평형대를 알고 있다면 작성해 주세요. </span>
                        <?= $row['space_size'] ?>
                    </div>                                                  
                <?php endif; ?>
                <?php if (in_array('appForUse', $itemArray)):?>
                    <div class="data-group">
                        <span class="zipdam_approval">집담에서 행위허가를 진행 하셨나요? </span>
                        <?= $row['zipdam_approval'] ?>
                    </div>                                                
                <?php endif; ?>
                <?php if (in_array('installScreen', $itemArray)):?>
                    <div class="data-group">
                        <span class="mang_type">방충망의 "망" 소재를 선택해 주세요.  </span>
                        <?= $row['mang_type'] ?>
                    </div>                                               
                    <div class="data-group">
                        <span class="mang_option">방충망 옵션을 선택해 주세요. </span>
                        <?= $row['mang_option'] ?>
                    </div>                                               
                <?php endif; ?>
                <?php if (in_array('wasteCollection', $itemArray)):?>
                    <div class="data-group">
                        <span class="waste_option">수거할 예상 폐기물량을 선택해주세요. </span>
                        <?= $row['waste_option'] ?>
                    </div>                                               
                    <div class="data-group">
                        <span class="waste_content">참고할 사항이 있다면 작성해 주세요.</span>
                        <?= nl2br(htmlspecialchars($row['waste_content'])) ?>
                    </div>                                               
                <?php endif; ?>

                <!--공통B-->
                <div class="data-group">
                    <span class="other_service_option">다른 서비스도 이용하실 예정이신가요? </span>
                    <?= $row['other_service_option'] ?>
                </div> 
                <div class="data-group">
                    <span class="payment_method">결제 방법을 선택해 주세요. </span>
                    <?= $row['payment_method'] ?>
                </div>        
                <div class="data-group">
                    <input type="checkbox" class="form-control" checked readonly> 접수 내용을 확인하였습니다.</span><br>
                    <input type="checkbox" class="form-control" checked readonly> 알림톡이 전송되면 대화창에 신청인명을 입력해주세요.</span>
                </div>

                <div class="data-group btns">
                    <button class="btn-back" onclick="history.back();">뒤로</button>
                </div>
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
