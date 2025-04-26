<footer class="footer mt-auto py-3 bg-dark fixed-bottom">
    <div class="container">
        <p class="m-0 text-center text-white">
            Copyright &copy; Space.com <?php echo date('Y'); ?> | <span id="live-clock"></span>
        </p>
    </div>
</footer>

<script>
    function updateLiveClock() {
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();

            clockElement.textContent = `${hours}:${minutes}:${seconds} ${day}/${month}/${year}`;
        }
    }

    // Gọi hàm lần đầu để hiển thị ngay
    updateLiveClock();
    // Đặt hẹn giờ để gọi lại hàm updateLiveClock mỗi 1000ms (1 giây)
    setInterval(updateLiveClock, 1000);
</script>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1 0 auto;
    }

    .footer {
        flex-shrink: 0;
    }
</style>