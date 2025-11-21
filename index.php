<?php include 'header.php'; ?>
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
                <div class="header">
                    <span>회원가입 없는</span> 간편한 서비스 신청
                </div>
                <div class="slider_wrap">
                    <ul class="slider_ul">
                        <li><img src="/img/main/main_slide01.jpg"></li>
                        <li><img src="/img/main/main_slide01.jpg"></li>
                        <li><img src="/img/main/main_slide01.jpg"></li>
                    </ul>
                    <a id="slider-prev" class="btn-prev" href="#"></a>
                    <a id="slider-next" class="btn-next" href="#"></a>
                    <div id="main-counter" class="counter">
                        <span class="current">1</span> / <span class="total"></span>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function(){
                        var mainSlider = $('.slider_ul').bxSlider({
                            mode: 'horizontal',
                            speed: 1500,
                            pause: 5000,	
                            auto: true,
                            shrinkItems: true,
                            hideControlOnEnd:true,
                            moveSlides:1,
                            infiniteLoop: true,
                            autoHover: true,
                            controls: true,
                            pager: false,
                            nextSelector: "#slider-next",
                            prevSelector: "#slider-prev",
                            nextText: '<i class="fa-solid fa-angle-right"></i>',
                            prevText: '<i class="fa-solid fa-angle-left"></i>',
                            onSlideBefore: function ($slideElement, oldIndex, newIndex){
                                var current_index = parseInt(newIndex + 1);
                                $('#main-counter .current').text(current_index);
                            }
                        });
                        $('#main-counter .total').text(mainSlider.getSlideCount());
                    });
                </script>                
                <div class="menu">
                    <div><label><input type="checkbox" name="selection" data-idx="agreement"><img src="/img/main/icon01.png" class="icon">입주민동의서</label></div>
                    <div><label><input type="checkbox" name="selection" data-idx="curing"><img src="/img/main/icon02.png" class="icon">보양</label></div>
                    <div><label><input type="checkbox" name="selection" data-idx="approval"><img src="/img/main/icon03.png" class="icon">행위허가</label></div>
                    <div><label><input type="checkbox" name="selection" data-idx="door"><img src="/img/main/icon04.png" class="icon">방화문,유리,문</label></div>
                    <div><label><input type="checkbox" name="selection" data-idx="remove"><img src="/img/main/icon05.png" class="icon">보양탈거</label></div>
                    <div><label><input type="checkbox" name="selection" data-idx="cleaning"><img src="/img/main/icon06.png" class="icon">입주청소</label></div>
                </div>
                <div id="layer" class="selection_btn">
                    <a id="apply-link" href="#"><span id="selection-count">0</span> 신청하기</a>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // 모든 체크박스를 초기화 (체크 해제)
                        const checkboxes = document.querySelectorAll('.menu input[type="checkbox"]');
                        const layer = document.getElementById('layer');
                        const selectionCount = document.getElementById('selection-count');
                        const applyLink = document.getElementById('apply-link');

                        // 체크박스 초기화
                        checkboxes.forEach(checkbox => checkbox.checked = false);

                        // 레이어 초기 상태 설정
                        layer.style.display = 'none';
                        selectionCount.textContent = '0';
                        applyLink.href = '#';

                        // 체크박스 상태 관리
                        checkboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function () {
                                const label = this.closest('label');
                                
                                // 선택 상태에 따라 클래스 추가/제거
                                if (this.checked) {
                                    label.classList.add('checked');
                                } else {
                                    label.classList.remove('checked');
                                }

                                // 선택된 항목의 `data-idx` 값을 배열로 관리
                                const selectedItems = Array.from(checkboxes)
                                    .filter(cb => cb.checked)
                                    .map(cb => cb.dataset.idx);

                                // 선택된 항목 개수 표시
                                selectionCount.textContent = selectedItems.length;

                                // GET 변수로 전달할 링크 생성
                                const queryString = selectedItems.length > 0 
                                    ? `?items=${selectedItems.join(',')}` 
                                    : '#';
                                applyLink.href = `/sub/request.php${queryString}`;

                                // 선택된 항목이 있으면 레이어 표시, 없으면 숨김
                                layer.style.display = selectedItems.length > 0 ? 'block' : 'none';
                            });
                        });
                    });

                    // 페이지 캐시 로드 시 체크박스 초기화
                    window.onpageshow = function (event) {
                        if ( event.persisted || (window.performance && window.performance.navigation.type == 2)) {
                            const checkboxes = document.querySelectorAll('.menu input[type="checkbox"]');
                            const layer = document.getElementById('layer');
                            const selectionCount = document.getElementById('selection-count');
                            const applyLink = document.getElementById('apply-link');

                            // 체크박스 초기화
                            checkboxes.forEach(checkbox => checkbox.checked = false);

                            // 초기 상태로 리셋
                            layer.style.display = 'none';
                            selectionCount.textContent = '0';
                            applyLink.href = '#';
                        }
                    };
                </script>

                <?php include 'footer.php'; ?>
            </div>

            <!-- 오른쪽 배경 -->
            <div class="background-right">
            </div>            
        </div>
    </div>
</body>
</html>
