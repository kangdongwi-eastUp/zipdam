<?php 
    include '../header.php'; 
    $items = isset($_GET['items']) ? $_GET['items'] : '';
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
                    <form id="requestForm" action="request.confirm.php" method="post">
                    <input type="hidden" name="items" value="<?= $items ?>">

                    <!--선택A-->
                    <?php if (in_array('agreement', $itemArray)||in_array('approval', $itemArray)):?>
                        <div class="form-group">
                            <label for="date_begin">
                                공사 기간을 입력해 주세요.<span class="required">*</span>
                                <p>아직, 확정되지 않았다면 예상일도 좋아요.</p>
                            </label>
                            <input type="date" id="date_begin" name="date_begin" class="form-control small" required> 부터 
                            <input type="date" id="date_end" name="date_end" class="form-control small" required>
                        </div>
                    <?php elseif (in_array('curing', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">공사 시작일 또는 시공희망일을 선택해 주세요.<span class="required">*</span></label>
                            <input type="date" id="date_begin" name="date_begin" class="form-control" required>
                        </div>
                    <?php elseif (in_array('door', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">
                                시공 희망일 또는 예상일을 입력해주세요.<span class="required">*</span>
                                <p>아파트의 특성상 휴일은 시공이 어려울 수 있습니다.</p>
                            </label>
                            <input type="date" id="date_begin" name="date_begin" class="form-control" required>
                        </div>
                    <?php elseif (in_array('remove', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">
                                보양 탈거 희망일 또는 예상일을 입력해주세요.<span class="required">*</span>
                                <p>보양탈거는 현장 특이 사항이 없는 이상 시간 지정은 어려워요.</p>
                            </label>
                            
                            <input type="date" id="date_begin" name="date_begin" class="form-control" required>
                        </div>
                    <?php elseif (in_array('cleaning', $itemArray)): ?>
                        <div class="form-group">
                            <label for="date_begin">입주청소 희망일을 선택해 주세요.<span class="required">*</span></label>
                            <input type="date" id="date_begin" name="date_begin" class="form-control" required>
                        </div>
                    <?php endif; ?>
                    
                    <!--공통A-->
                    <div class="form-group">
                        <label for="address">현장 주소를 입력해 주세요.<span class="required">*</span></label>
                        <input type="hidden" id="postcode" name="postcode" placeholder="우편번호">
                        <input type="text" id="address" name="address" placeholder="주소" class="address" required> <input type="button" onclick="execDaumPostcode()" class="address_btn" value="주소찾기">
                        <input type="text" id="detailAddress" name="detailAddress" placeholder="상세주소" required>
                    </div>
                    <div class="form-group">
                        <label for="name">신청인명과 연락처를 입력해 주세요.<span class="required">*</span></label>
                        <input type="text" id="name" name="name" placeholder="성명" class="form-control small" required>
                        <input type="text" id="phone" name="phone" placeholder="연락처 (숫자만입력)" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="type">신청인이 개인 또는 업체 이실까요?</label>
                        <ul>
                            <li><label><input type="radio" name="type" value="직영 공사 (셀프로 공정별 업체 선정하여 운영)" checked> 직영 공사 (셀프로 공정별 업체 선정하여 운영)</label></li>
                            <li>
                                <label>
                                    <input type="radio" name="type" value="업체 (공사 업체)"> 업체 (공사 업체)<br>
                                    <input type="text" id="company" name="company" placeholder="업체명을 작성해 주세요." class="form-control medium ml22">
                                </label>
                            </li>
                        </ul>
                    </div>

                    <!--선택B-->
                    <?php if (in_array('agreement', $itemArray)||in_array('approval', $itemArray)):?>
                        <div class="form-group">
                            <label for="address">
                                현장 담당자명과 연락처를 작성해 주세요.
                                <p>게시되는 공사안내문에 표기됩니다.</p>
                            </label>
                            <ul>
                                <li><label><input type="radio" name="poc" value="신청인과 같아요." checked> 신청인과 같아요.</label></li>
                                <li><label><input type="radio" name="poc" value="지금은 모르니 확정도면 별도 알려드릴께요."> 지금은 모르니 확정도면 별도 알려드릴께요.</label></li>
                                <li>
                                    <label>
                                        <input type="radio" name="poc" value="다른분이 있어요."> 다른분이 있어요.<br>
                                        <input type="text" id="poc_name" name="poc_name" placeholder="성명" class="form-control small ml22">
                                        <input type="text" id="poc_phone" name="poc_phone" placeholder="연락처 (숫자만입력)" class="form-control medium ml22">
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="residence">
                                입주자의 성명과 연락처를 작성해 주세요.
                                <p>관리사무소 공사신고시 필요한 정보이며 실제와 달라도 무관합니다.</p>
                            </label>
                            <ul>
                                <li><label><input type="radio" name="residence" value="신청인과 같아요." checked> 신청인과 같아요.</label></li>
                                <li><label><input type="radio" name="residence" value="지금은 모르니 확정도면 별도 알려드릴께요."> 지금은 모르니 확정도면 별도 알려드릴께요.</label></li>
                                <li>
                                    <label>
                                        <input type="radio" name="residence" value="다른분이 있어요."> 다른분이 있어요.<br>
                                        <input type="text" id="residence_name" name="residence_name" placeholder="성명" class="form-control small ml22">
                                        <input type="text" id="residence_phone" name="residence_phone" placeholder="연락처 (숫자만입력)" class="form-control medium ml22">
                                    </label>
                                </li>
                            </ul>
                        </div>                                         
                    <?php endif; ?>

                    <!--개별-->
                    <?php if (in_array('agreement', $itemArray)):?>
                        <div class="form-group">
                            <label for="construction">
                                공사내용을 선택해 주세요.
                                <p>발코니 확장, 비내력벽철거, 화단철거 등은 관할청에 행위허가를 받고 착공하는것이 가장 안전합니다.</p>
                            </label>
                            <div class="radio_wrap">
                                <label><input type="radio" name="construction" value="도배" checked> 도배</label>
                                <label><input type="radio" name="construction" value="바닥"> 바닥</label>
                                <label><input type="radio" name="construction" value="필름"> 필름</label>
                                <label><input type="radio" name="construction" value="가구"> 가구</label>
                                <label><input type="radio" name="construction" value="씽크대"> 씽크대</label>
                                <label><input type="radio" name="construction" value="목공"> 목공</label>
                                <label><input type="radio" name="construction" value="도어"> 도어</label>
                                <label><input type="radio" name="construction" value="타일"> 타일</label>
                                <label><input type="radio" name="construction" value="페인트"> 페인트</label>
                                <label><input type="radio" name="construction" value="창호"> 창호</label>
                                <label><input type="radio" name="construction" value="전기.조명"> 전기.조명</label>
                                <label><input type="radio" name="construction" value="욕실(기존타일도철거)"> 욕실(기존타일도철거)</label>
                                <label><input type="radio" name="construction" value="욕실(덧시공)"> 욕실(덧시공)</label>
                                <label><input type="radio" name="construction" value="일반철거"> 일반철거</label>
                                <label><input type="radio" name="construction" value="화단철거"> 화단철거</label>
                                <label><input type="radio" name="construction" value="반침철거"> 반침철거</label>
                                <label><input type="radio" name="construction" value="다용도실철거"> 다용도실철거</label>
                                <label><input type="radio" name="construction" value="그외 비내력벽철거"> 그외 비내력벽철거</label>
                                <label><input type="radio" name="construction" value="거실확장"> 거실확장</label>
                                <label><input type="radio" name="construction" value="침실확장"> 침실확장</label>
                                <label><input type="radio" name="construction" value="주방확장"> 주방확장</label>
                                <label><input type="radio" name="construction" value="그외 확장"> 그외 확장</label>
                                <label><input type="radio" name="construction" value="바닥난방 재시공(전체철거후)"> 바닥난방 재시공(전체철거후)</label>
                                <label><input type="radio" name="construction" value="기타"> 기타
                                <input type="text" name="construction_etc" class="form-control medium ml22"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_noise">
                                공사중 소음이 집중되는 예상일은 언제일까요?
                                <p>확정하기 어려우면 착고일로부터 3일로 신고해드려요.</p>
                            </label>
                            <input type="text" id="date_noise" name="date_noise" class="form-control">
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('curing', $itemArray)):?>
                        <div class="form-group">
                            <label for="curing">
                                원하시는 보양 유형을 선택해 주세요.
                                <p>중복 선택이 가능합니다.</p>
                            </label>
                            <div class="radio_wrap">
                                <label><input type="checkbox" name="curing[]" value="올보양"> 올보양</label>
                                <label><input type="checkbox" name="curing[]" value="준보양"> 준보양</label>
                                <label><input type="checkbox" name="curing[]" value="하프보양"> 하프보양</label>
                                <label><input type="checkbox" name="curing[]" value="바닥 또는 벽 보양"> 바닥 또는 벽 보양</label>
                                <label><input type="checkbox" name="curing[]" value="관리사무소 규정에 따라 보양 시공"> 관리사무소 규정에 따라 보양 시공</label>
                                <label><input type="checkbox" name="curing[]" value="기타"> 기타
                                <input type="text" name="curing_etc" class="form-control medium ml22"></label>
                            </div>
                        </div>                        
                    <?php endif; ?>
                    <?php if (in_array('approval', $itemArray)):?>
                        <div class="form-group">
                            <label for="status">
                                현장의 상태를 선택해 주세요.
                            </label>
                            <div class="radio_wrap">
                                <label><input type="radio" name="status" value="현재 소유중 입니다."> 현재 소유중 입니다.</label>
                                <label><input type="radio" name="status" value="매매중이며 잔금전 입니다."> 매매중이며 잔금전 입니다.</label>
                                <label><input type="radio" name="status" value="기존에 확장 또는 비내력벽 철거가 있어요."> 기존에 확장 또는 비내력벽 철거가 있어요.</label>
                                <label><input type="radio" name="status" value="현재 정확히 알수 없는 상태 입니다."> 현재 정확히 알수 없는 상태 입니다.</label>
                            </div>
                        </div>                  
                        <div class="form-group">
                            <label for="object">
                                계획하신 행위허가 대상을 선택해 주세요.
                            </label>
                            <div class="radio_wrap">
                                <label><input type="radio" name="object" value="거실확장"> 거실확장</label>
                                <label><input type="radio" name="object" value="침실확장"> 침실확장</label>
                                <label><input type="radio" name="object" value="주방확장"> 주방확장</label>
                                <label><input type="radio" name="object" value="다용도실확장"> 다용도실확장</label>
                                <label><input type="radio" name="object" value="화단철거"> 화단철거</label>
                                <label><input type="radio" name="object" value="비내력벽철거"> 비내력벽철거</label>
                                <label><input type="radio" name="object" value="가벽신설등으로 일부 구조변경"> 가벽신설등으로 일부 구조변경</label>
                                <label><input type="radio" name="object" value="기타"> 기타
                                <input type="text" name="object_etc" class="form-control medium ml22"></label>
                            </div>
                        </div>                                     
                    <?php endif; ?>
                    <?php if (in_array('door', $itemArray)):?>
                        <div class="form-group">
                            <label for="zipdam_approval">
                                집담에서 행위허가를 진행 하셨나요?
                            </label>
                            <div class="radio_wrap">
                                <label><input type="radio" name="zipdam_approval" value="네. 집담에서 행위허가를 했어요."> 네. 집담에서 행위허가를 했어요.</label>
                                <label><input type="radio" name="zipdam_approval" value="아니요. 소방시설만 별도 의뢰 할 예정입니다."> 아니요. 소방시설만 별도 의뢰 할 예정입니다.</label>
                            </div>
                        </div>     
                        <div class="form-group">
                            <label for="door_product">
                                의뢰하실 품목을 모두 선택해 주세요.
                                <p>신청후 전문 상담원이 별도 전화 드릴 예정 입니다.</p>
                            </label>
                            <div class="radio_wrap">
                                <label><input type="checkbox" name="door_product[]" value="방화판 출장 시공을 바랍니다."> 방화판 출장 시공을 바랍니다.</label>
                                <label><input type="checkbox" name="door_product[]" value="방화판 셋트만 배송 받고 싶어요."> 방화판 셋트만 배송 받고 싶어요.</label>
                                <label><input type="checkbox" name="door_product[]" value="방화유리 실측후 출장 시공을 바랍니다."> 방화유리 실측후 출장 시공을 바랍니다.</label>
                                <label><input type="checkbox" name="door_product[]" value="갑종 방화문 셋트만 배송 받고 싶어요."> 갑종 방화문 셋트만 배송 받고 싶어요.</label>
                                <label><input type="checkbox" name="door_product[]" value="갑종 방화문 실측후 출장 시공을 바랍니다."> 갑종 방화문 실측후 출장 시공을 바랍니다.</label>
                                <label><input type="checkbox" name="door_product[]" value="화재감지기 셋트만 배송 받고 싶어요."> 화재감지기 셋트만 배송 받고 싶어요.</label>
                                <label><input type="checkbox" name="door_product[]" value="화재감지기 출장 시공을 바랍니다."> 화재감지기 출장 시공을 바랍니다.</label>
                            </div>
                        </div>                             
                    <?php endif; ?>
                    <?php if (in_array('remove', $itemArray)):?>
                        <div class="form-group">
                            <label for="remove_object">
                                탈거할 보양 유형을 선택해주세요.
                                <p>탈거후 폐기, 기본 정리를 포함하는 서비스 이며, 집담에서 보양하지 않은 보양재는 제외됩니다.</p>
                            </label>
                            <div class="radio_wrap">
                                <label><input type="radio" name="remove_object" value="승강기 보양만 탈거해 주세요."> 승강기 보양만 탈거해 주세요.</label>
                                <label><input type="radio" name="remove_object" value="승강기 보양과 동선 보양 모두 탈거해 주세요."> 승강기 보양과 동선 보양 모두 탈거해 주세요.</label>
                                <label><input type="radio" name="remove_object" value="바닥 또는 벽 보양만 탈거해주세요."> 바닥 또는 벽 보양만 탈거해주세요.</label>
                                <label><input type="radio" name="remove_object" value="부분 탈거만 있으니 탈거전 별도 연락 주세요."> 부분 탈거만 있으니 탈거전 별도 연락 주세요.</label>
                            </div>
                        </div>   
                    <?php endif; ?>
                    <?php if (in_array('cleaning', $itemArray)):?>
                        <div class="form-group">
                            <label for="space_type">
                                현장의 공간 유형을 선택해 주세요.
                            </label>
                            <div class="radio_wrap">
                                <label><input type="radio" name="space_type" value="공동주책 (아파트, 빌라, 주상복합 등)"> 공동주책 (아파트, 빌라, 주상복합 등)</label>
                                <label><input type="radio" name="space_type" value="사무공간 (사무실, 지식산업센터 등)"> 사무공간 (사무실, 지식산업센터 등)</label>
                                <label><input type="radio" name="space_type" value="상업공간 (음식점, 판매점 등)"> 상업공간 (음식점, 판매점 등)</label>
                                <label><input type="radio" name="space_type" value="공장공간 (공장 등)"> 공장공간 (공장 등)</label>
                                <label><input type="radio" name="space_type" value="기타 공간으로 사전 상담이 필요합니다."> 기타 공간으로 사전 상담이 필요합니다.</label>
                            </div>
                        </div>        
                        <div class="form-group">
                            <label for="space_size">
                                공간의 실 평형대를 알고 있다면 작성해 주세요.
                                <p>정확한 평수가 아니어도 무관하며 서비스 신청후 전문 상담이 있을 예정입니다.</p>
                            </label>
                            <input type="text" id="space_size" name="space_size" class="form-control" placeholder="평수를 작성해 주세요.">
                        </div>                                                  
                    <?php endif; ?>

                    <!--공통B-->
                    <div class="form-group">
                        <label for="payment_method"> 
                            결제 방법을 선택해 주세요.
                            <p>서비스 신청이 완료되면 결제 금액은 별도 안내해 드려요.</p>
                        </label>
                        <div class="radio_wrap">
                            <label><input type="radio" name="payment_method" value="계좌 송금 예정입니다."> 계좌 송금 예정입니다.<br><span class="ml22">(현금영수증, 세금계산서)</span></label>
                            <label><input type="radio" name="payment_method" value="간편 결제 예정입니다."> 간편 결제 예정입니다.<br><span class="ml22">(신용카드, 네이버페이, 카카오페이, 네이버스토어)</span></label>
                        </div>
                    </div>        
                    <div class="form-group">
                        <label><input type="checkbox" name="check_all" id="check_all"> 모두 선택</label>
                        <label><input type="checkbox" name="consent01" id="consent01" value="y" class="agree" required> 개인정보 수집 및 이용동의 (<a href="document.php?no=1">전체보기</a>)</label>
                        <label><input type="checkbox" name="consent02" id="consent02" value="y" class="agree" required> 개인정보 제3자 제공동의 (<a href="document.php?no=2">전체보기</a>)</label>
                        <label><input type="checkbox" name="consent03" id="consent03" value="y" class="agree"> 마케팅활용 정보동의 (선택) (<a href="document.php?no=3">전체보기</a>)</label>
                    </div>

                    <div class="form-group btns">
                        <button type="submit" class="btn-submit">접수하기</button>
                        <button class="btn-back" onclick="history.back();">뒤로</button>
                    </div>
                    </form>
                </div>
                <?php include '../footer.php'; ?>
            </div>

            <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
            <script>
                // 다음 우편번호 API
                function execDaumPostcode() {
                    new daum.Postcode({
                        oncomplete: function(data) {
                            var roadAddr = data.roadAddress;
                            var extraRoadAddr = '';

                            if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                                extraRoadAddr += data.bname;
                            }

                            if(data.buildingName !== '' && data.apartment === 'Y'){
                            extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                            }

                            if(extraRoadAddr !== ''){
                                extraRoadAddr = ' (' + extraRoadAddr + ')';
                            }

                            document.getElementById('postcode').value = data.zonecode;
                            document.getElementById("address").value = roadAddr;
                        }
                    }).open();
                }
                // 모두 선택 체크박스
                document.addEventListener('DOMContentLoaded', () => {
                    const checkAll = document.getElementById('check_all');
                    const checkboxes = document.querySelectorAll('input[type="checkbox"].agree'); // 클래스가 agree인 체크박스만 선택

                    checkAll.addEventListener('change', () => {
                        const isChecked = checkAll.checked;
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = isChecked;
                        });
                    });

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', () => {
                            // 모든 agree 체크박스가 체크되었는지 확인
                            checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                        });
                    });
                });

            </script>
            <!-- 오른쪽 배경 -->
            <div class="background-right">
            </div>            
        </div>
    </div>
</body>
</html>
