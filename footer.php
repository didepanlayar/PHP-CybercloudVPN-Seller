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

            const createPage = document.getElementById('protocol');
            const createSsh = document.getElementById('create-ssh');
            const createVmess = document.getElementById('create-vmess');
            const createVless = document.getElementById('create-vless');
            const createTrojan = document.getElementById('create-trojan');

            if (createPage) {
                createSsh.style.display = 'none';
                createVmess.style.display = 'none';
                createVless.style.display = 'none';
                createTrojan.style.display = 'none';

                createPage.addEventListener('change', function() {
                    var protocol = this.value;

                    createSsh.style.display = protocol === 'create-ssh' ? 'block' : 'none';
                    createVmess.style.display = protocol === 'create-vmess' ? 'block' : 'none';
                    createVless.style.display = protocol === 'create-vless' ? 'block' : 'none';
                    createTrojan.style.display = protocol === 'create-trojan' ? 'block' : 'none';

                    if (protocol === 'create-ssh') {
                        createSsh.querySelectorAll('input, textarea').forEach(function(elem) {
                            elem.setAttribute('required', 'required');
                        });
                    } else if (protocol === 'create-vmess') {
                        createVmess.querySelectorAll('input, textarea').forEach(function(elem) {
                            elem.setAttribute('required', 'required');
                        });
                    } else if (protocol === 'create-vless') {
                        createVless.querySelectorAll('input, textarea').forEach(function(elem) {
                            elem.setAttribute('required', 'required');
                        });
                    } else if (protocol === 'create-trojan') {
                        createTrojan.querySelectorAll('input, textarea').forEach(function(elem) {
                            elem.setAttribute('required', 'required');
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>