<?php 
    include '../header.php'; 
?>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

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
                        <div class="header">
                            <img src="/img/completed.jpg">
                            <h2>접수완료</h2>
                        </div>
                        <p>
                            지금, 알림톡이 전송되었습니다.<br>
                            대화창에 신청인명을 입력하시면<br>
                            더 빠른 업무처리에 도움이 됩니다.
                        </p>
                       <button type="button" class="btn-submit" onClick="location.href='../index.php'">확인</button>
                </div>
                <?php include '../footer.php'; ?>
            </div>

            <!-- 오른쪽 배경 -->
            <div class="background-right">
            </div>            
        </div>
    </div>

    <script>
        // Confetti 실행 함수
        function fireConfetti() {
            confetti({
                particleCount: 100, // 파티클 개수
                spread: 70,         // 파티클 퍼짐 각도
                origin: { x: 0.5, y: 0.5 }, // 시작 위치 (중앙)
                colors: ['#ff0000', '#00ff00', '#0000ff'], // 색상 설정
            });
        }

        // 페이지 로딩 후 Confetti 자동 실행
        document.addEventListener('DOMContentLoaded', function () {
            fireConfetti();

            // 일정 간격으로 반복 실행 (선택 사항)
            const interval = setInterval(fireConfetti, 1000); // 1초마다 실행

            // 특정 시간 후 반복 중지 (선택 사항)
            setTimeout(function () {
                clearInterval(interval);
            }, 5000); // 5초 후 중지
        });
    </script>    
</body>
</html>
