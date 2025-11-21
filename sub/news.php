<?php 
    include '../header.php';
    include '../adm/inc.db.com.php';

    // 현재 페이지 번호 가져오기 (기본값 1)
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $per_page = 5; // 페이지당 게시글 수
    $offset = ($current_page - 1) * $per_page;

    // 전체 게시글 수 가져오기
    $total_result = $mysqli->query("SELECT COUNT(*) AS total FROM board_news");
    $total_row = $total_result->fetch_assoc();
    $total_count = $total_row['total'];
    $total_pages = ceil($total_count / $per_page); // 전체 페이지 수 계산

    // 데이터 가져오기
    $result = $mysqli->query("SELECT * FROM board_news ORDER BY created_at DESC LIMIT $offset, $per_page");
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
                <div class="header">
                    <h1>새로운 소식과<br>이벤트로 여러분과 함께 해요.</h1>
                    <p>집담은 더 나은 서비스를 제공하고<br>지속할 수 있도록 끊임 없는 연구를 합니다.</p>
                </div>
                <div class="image">
                    <img src="/img/sub/news_header.png" alt="소식">
                </div>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="news_content">
                        <span class="dt"><?= date('Y년 m월 d일', strtotime($row['created_at'])); ?></span>
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
                                <img src="<?= htmlspecialchars($web_path) ?>" alt="첨부 이미지">
                            <?php else: ?>
                                <p class="desc"><a href="<?= htmlspecialchars($web_path) ?>" download><?= htmlspecialchars($file_name_prnt) ?></a></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>

                <!-- 페이징 -->
                <div class="pagination">
                    <?php if ($current_page > 1): ?>
                        <a href="?page=<?= $current_page - 1 ?>" class="prev">이전</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="<?= $i === $current_page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="?page=<?= $current_page + 1 ?>" class="next">다음</a>
                    <?php endif; ?>
                </div>
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
