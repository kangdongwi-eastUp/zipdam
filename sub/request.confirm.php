<?php 
    include '../header.php'; 
    $items = isset($_POST['items']) ? $_POST['items'] : '';
    if (!empty($items)) {
        // ','로 구분된 문자열을 배열로 변환
        $itemArray = explode(',', $items);
    } else {
        $error_message = "잘못된 접근입니다.";
    }
?>
    <div class="container">
        <!-- 전체 배경 -->
        <div class="background">
            <!-- 왼쪽 텍스트 배경 -->
            <div class="background-left">
                <div class="logo">
                    <a href="/"><img src="/img/logo.png"></a>
                </div>
                <div class="text">
                    <h1>집담으로<br>인테리어를 쉽고,<br>편하게 시작하세요</h1>
                    <div class="badges">
                        <span><img src="/img/icon_left_01.png"> 전국운영</span>
                        <span><img src="/img/icon_left_02.png"> 365 연중무휴</span>
                        <span><img src="/img/icon_left_03.png"> 간편결제</span>
                    </div>
                    <div class="badges">
                        <span><img src="/img/icon_left_04.png"> 안전결제</span>
                        <span><img src="/img/icon_left_05.png"> 직영운영</span>
                    </div>                    
                </div>
                <div class="icons">
                    <img src="/img/icon_naverpay.png">
                    <img src="/img/icon_kakaopay.png">
                </div>
            </div>

            <!-- 중앙 모바일 UI -->
            <div class="mobile-box">
                <div class="content_wrap">
                    <div class="information">신청 내용을 다시 한번 확인 해 주세요 :)</div>
                    <form id="requestForm" action="request.process.php" method="post">
                    <input type="hidden" name="items" value="<?= $items ?>">
                    <input type="hidden" name="consent01" id="consent01" value="<?= $_POST['consent01'] ?>">
                    <input type="hidden" name="consent02" id="consent02" value="<?= $_POST['consent02'] ?>">
                    <input type="hidden" name="consent03" id="consent03" value="<?= $_POST['consent03'] ?>">

                    <?php
                        //변수정리
                        $date_begin = isset($_POST['date_begin']) ? $_POST['date_begin'] : null;
                        $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : null;
                        $formatted_begin = date('Y년 m월 d일', strtotime($date_begin));
                        $formatted_end = date('Y년 m월 d일', strtotime($date_end));
                    ?>

                    <!--선택A-->
                    <?php if (in_array('agreement', $itemArray)||in_array('approval', $itemArray)):?>
                        <div class="form-group">
                            <label for="date_begin">공사 기간을 입력해 주세요. </label>
                            <?php $date_prnt = "{$formatted_begin} 부터 {$formatted_end} 까지"; ?>
                            <input type="text" id="date_prnt" name="date_prnt" class="form-control" value="<?= $date_prnt ?>" readonly>
                        </div>
                    <?php elseif (in_array('curing', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">공사 시작일 또는 시공희망일을 선택해 주세요.</label>
                            <?php $date_prnt = "{$formatted_begin}"; ?>
                            <input type="text" id="date_prnt" name="date_prnt" class="form-control" value="<?= $date_prnt ?>" readonly>
                        </div>
                    <?php elseif (in_array('door', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">시공 희망일 또는 예상일을 입력해주세요. </label>
                            <?php $date_prnt = "{$formatted_begin}"; ?>
                            <input type="text" id="date_prnt" name="date_prnt" class="form-control" value="<?= $date_prnt ?>" readonly>
                        </div>
                    <?php elseif (in_array('remove', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">보양 탈거 희망일 또는 예상일을 입력해주세요. </label>
                            <?php $date_prnt = "{$formatted_begin}"; ?>
                            <input type="text" id="date_prnt" name="date_prnt" class="form-control" value="<?= $date_prnt ?>" readonly>
                        </div>
                    <?php elseif (in_array('cleaning', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">입주청소 희망일을 선택해 주세요.</label>
                            <?php $date_prnt = "{$formatted_begin}"; ?>
                            <input type="text" id="date_prnt" name="date_prnt" class="form-control" value="<?= $date_prnt ?>" readonly>
                        </div>
                    <?php endif; ?>
                    
                    <!--공통A-->
                    <div class="form-group">
                        <label for="address">현장 주소를 입력해 주세요.</label>
                        <input type="text" id="address" name="address" value="<?= $_POST['address'] ?>" readonly>
                        <input type="text" id="detailAddress" name="detailAddress" value="<?= $_POST['detailAddress'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">신청인명과 연락처를 입력해 주세요.</label>
                        <input type="text" id="name" name="name" value="<?= $_POST['name'] ?>" class="small" readonly>
                        <input type="text" id="phone" name="phone" value="<?= $_POST['phone'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="type">신청인이 개인 또는 업체 이실까요?</label>
                        <input type="text" id="type" name="type" value="<?= $_POST['type'] ?>" readonly>
                        <?php if ($_POST['type'] == '업체 (공사 업체)'): ?>
                            <input type="text" id="company" name="company" value="<?= $_POST['company'] ?>" readonly>
                        <?php endif; ?>
                    </div>

                    <!--선택B-->
                    <?php if (in_array('agreement', $itemArray)||in_array('approval', $itemArray)):?>
                        <div class="form-group">
                            <label for="address">현장 담당자명과 연락처를 작성해 주세요. </label>
                            <input type="text" id="poc" name="poc" value="<?= $_POST['poc'] ?>"readonly>
                            <?php if ($_POST['poc'] == '다른분이 있어요.'): ?>
                                <input type="text" id="poc_name" name="poc_name" value="<?= $_POST['poc_name'] ?>" readonly>
                                <input type="text" id="poc_phone" name="poc_phone" value="<?= $_POST['poc_phone'] ?>" readonly>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="residence">입주자의 성명과 연락처를 작성해 주세요. </label>
                            <input type="text" id="resident" name="residence" value="<?= $_POST['residence'] ?>" readonly>
                            <?php if ($_POST['residence'] == '다른분이 있어요.'): ?>
                                <input type="text" id="residence_name" name="residence_name" value="<?= $_POST['residence_name'] ?>" readonly>
                                <input type="text" id="residence_phone" name="residence_phone" value="<?= $_POST['residence_phone'] ?>" readonly>
                            <?php endif; ?>
                        </div>                                         
                    <?php endif; ?>

                    <!--개별-->
                    <?php if (in_array('agreement', $itemArray)):?>
                        <div class="form-group">
                            <label for="construction">공사내용을 선택해 주세요. </label>
                            <input type="text" id="construction" name="construction" value="<?= $_POST['construction'] ?>" readonly>
                            <?php if ($_POST['construction'] == '기타'): ?>
                                <input type="text" id="construction_etc" name="construction_etc" value="<?= $_POST['construction_etc'] ?>" readonly>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="date_noise">공사중 소음이 집중되는 예상일은 언제일까요? </label>
                            <input type="text" id="date_noise" name="date_noise" value="<?= $_POST['date_noise'] ?>" readonly>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('curing', $itemArray)):?>
                        <div class="form-group">
                            <label for="curing">원하시는 보양 유형을 선택해 주세요. </label>
                            <?php $curing = implode(', ', $_POST['curing']); ?>
                            <input type="text" id="curing" name="curing" value="<?= $curing ?>" readonly>
                            <?php if (in_array('기타', $_POST['curing'])): ?>
                                <input type="text" id="curing_etc" name="curing_etc" value="<?= $_POST['curing_etc'] ?>" readonly>
                            <?php endif; ?>
                        </div>                        
                    <?php endif; ?>
                    <?php if (in_array('approval', $itemArray)):?>
                        <div class="form-group">
                            <label for="status">현장의 상태를 선택해 주세요. </label>
                            <input type="text" id="status" name="status" value="<?= $_POST['status'] ?>" readonly>
                        </div>                  
                        <div class="form-group">
                            <label for="object">계획하신 행위허가 대상을 선택해 주세요. </label>
                            <input type="text" id="object" name="object" value="<?= $_POST['object'] ?>" readonly>
                            <?php if ($_POST['object'] == '기타'): ?>
                                <input type="text" id="object_etc" name="object_etc" value="<?= $_POST['object_etc'] ?>" readonly>
                            <?php endif; ?>
                        </div>                                     
                    <?php endif; ?>
                    <?php if (in_array('door', $itemArray)):?>
                        <div class="form-group">
                            <label for="zipdam_approval">집담에서 행위허가를 진행 하셨나요? </label>
                            <input type="text" id="zipdam_approval" name="zipdam_approval" value="<?= $_POST['zipdam_approval'] ?>" readonly>
                        </div>     
                        <div class="form-group">
                            <label for="door_product">의뢰하실 품목을 모두 선택해 주세요. </label>
                            <?php $door_product = implode(', ', $_POST['door_product']); ?>
                            <input type="text" id="door_product" name="door_product" value="<?= $door_product ?>" readonly>
                        </div>                             
                    <?php endif; ?>
                    <?php if (in_array('remove', $itemArray)):?>
                        <div class="form-group">
                            <label for="remove_object">탈거할 보양 유형을 선택해주세요. </label>
                            <input type="text" id="remove_object" name="remove_object" value="<?= $_POST['remove_object'] ?>" readonly>
                        </div>   
                    <?php endif; ?>
                    <?php if (in_array('cleaning', $itemArray)):?>
                        <div class="form-group">
                            <label for="space_type">현장의 공간 유형을 선택해 주세요. </label>
                            <input type="text" id="space_type" name="space_type" value="<?= $_POST['space_type'] ?>" readonly>
                        </div>        
                        <div class="form-group">
                            <label for="space_size">공간의 실 평형대를 알고 있다면 작성해 주세요. </label>
                            <input type="text" id="space_size" name="space_size" value="<?= $_POST['space_size'] ?>" readonly>
                        </div>                                                  
                    <?php endif; ?>

                    <!--공통B-->
                    <div class="form-group">
                        <label for="payment_method">결제 방법을 선택해 주세요. </label>
                        <input type="text" id="payment_method" name="payment_method" value="<?= $_POST['payment_method'] ?>" readonly>
                    </div>        
                    <div class="form-group">
                        <label><input type="checkbox" name="check_confirm" value="y" class="form-control" required> 접수 내용을 확인하였습니다.</label>
                        <label><input type="checkbox" name="check_alrim" value="y" rclass="form-control" required> 알림톡이 전송되면 대화창에 신청인명을 입력해주세요.</label>
                    </div>

                    <div class="form-group btns">
                        <button type="submit" class="btn-submit">접수하기</button>
                        <button class="btn-back" onclick="history.back();">뒤로</button>
                    </div>
                    </form>
                </div>
                <?php include '../footer.php'; ?>
            </div>

            <!-- 오른쪽 배경 -->
            <div class="background-right">
            </div>            
        </div>
    </div>
</body>
</html>
