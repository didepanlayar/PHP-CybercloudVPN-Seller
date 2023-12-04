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
        $('#table-server').DataTable({
            "ordering": false,
            "sScrollX": '100%',
            "rowReorder": {
                "selector": 'td:nth-child(2)'
            }
        });
    }

    const createPage = document.getElementById('protocol');

    if (createPage) {
        const createSsh = document.getElementById('create-ssh');
        const createVmess = document.getElementById('create-vmess');
        const createVless = document.getElementById('create-vless');
        const createTrojan = document.getElementById('create-trojan');
        
        createSsh.style.display = 'none';
        createVmess.style.display = 'none';
        createVless.style.display = 'none';
        createTrojan.style.display = 'none';

        createPage.addEventListener('change', function() {
            var protocol = this.value;
            const protocols = ['ssh', 'vmess', 'vless', 'trojan'];

            createSsh.style.display = protocol === 'create-ssh' ? 'block' : 'none';
            createVmess.style.display = protocol === 'create-vmess' ? 'block' : 'none';
            createVless.style.display = protocol === 'create-vless' ? 'block' : 'none';
            createTrojan.style.display = protocol === 'create-trojan' ? 'block' : 'none';

            protocols.forEach(function (p) {
                const createProtocol = document.getElementById(`create-${p}`);
                createProtocol.querySelectorAll('input, textarea').forEach(function (elem) {
                    if (protocol === `create-${p}`) {
                        elem.setAttribute('required', 'required');
                    } else {
                        elem.removeAttribute('required');
                    }
                });
            });
        });
    }
});