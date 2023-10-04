        </div>
    </div>
    <!-- Javascripts -->
    <script src="<?php echo $data['siteurl']; ?>/assets/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="<?php echo $data['siteurl']; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="<?php echo $data['siteurl']; ?>/assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $data['siteurl']; ?>/assets/plugins/pace/pace.min.js"></script>
    <script src="<?php echo $data['siteurl']; ?>/assets/plugins/DataTables/datatables.min.js"></script>
    <script src="<?php echo $data['siteurl']; ?>/assets/js/main.min.js"></script>
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

            const inputAuthentication = document.getElementById('authentication');
            const btnChangePassword = document.getElementById('btn-change-password');

            if (btnChangePassword) {
                btnChangePassword.addEventListener('click', function() {
                    if (inputAuthentication.disabled === true) {
                        inputAuthentication.removeAttribute('disabled');
                        inputAuthentication.focus();
                        btnChangePassword.innerText = 'Cancel';
                    } else {
                        inputAuthentication.setAttribute('disabled', 'disabled');
                        btnChangePassword.innerText = 'Change Password';
                        inputAuthentication.value = '';
                    }
                });
            }
        });

        function setNumber(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
                return true;
            }
        }

        $(document).ready(function() {
            const tableServer = document.getElementById('table-server');

            if (tableServer) {
                $('#table-server').DataTable();
            }
        });
    </script>
</body>
</html>