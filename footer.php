        </div>
    </div>
    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const closeButton = document.querySelector('.btn-close');
            const rowDiv = document.querySelector('.row-close');

            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    if (rowDiv) {
                        rowDiv.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>