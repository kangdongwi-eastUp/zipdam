                <div class="footer">
                    <nav>
                        <a href="/"><img src="/img/icon_bottom_01.png">홈</a>
                        <a href="/sub/pricing.php"><img src="/img/icon_bottom_02.png">단가표</a>
                        <a href="http://pf.kakao.com/_tAcdn/chat" target="_blank"><img src="/img/icon_bottom_03.png">채팅</a>
                        <a href="/sub/news.php"><img src="/img/icon_bottom_04.png">소식</a>
                        <a href="/sub/company.php"><img src="/img/icon_bottom_05.png">회사소개</a>
                    </nav>
                </div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.footer nav a');

    navLinks.forEach(link => {
        const linkPath = new URL(link.href).pathname;
        // 홈 링크('/')는 'index.php'와도 일치해야 합니다.
        if (linkPath === currentPath || (linkPath === '/' && currentPath === '/index.php')) {
            link.classList.add('active'); // active 클래스 추가
            const img = link.querySelector('img');
            if (img) {
                const originalSrc = img.getAttribute('src');
                img.setAttribute('src', originalSrc.replace('.png', '_sel.png'));
            }
        }
    });
});
</script>