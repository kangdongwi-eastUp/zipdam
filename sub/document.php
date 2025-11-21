<?php
    include '../header.php'; 
    if (isset($_GET['no'])) $no = $_GET['no'];
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
                <?php 
                    if ($no)  include 'document.0'.$no.'.php';
                    else echo '잘못된 접근입니다.';
                ?>
                <button class="btn-back" onclick="history.back();">뒤로</button>
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
