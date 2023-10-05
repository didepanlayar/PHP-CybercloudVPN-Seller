<?php

require_once 'includes/session.php';

get_session();

$title = 'Create';

include 'header.php';
include 'sidebar.php';

?>
            <div class="main-wrapper">
                <?php if (isset($_SESSION['status'])) : ?>
                    <div class="row px-5 row-close">
                        <div class="col">
                            <?php status_message(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <form action="includes/controller.php" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="protocol" class="form-label">Protocol</label>
                                            <select class="form-select" id="protocol" name="protocol" required>
                                                <option value="">Select Protocol</option>
                                                <option value="create-ssh">SSH & OpenVPN</option>
                                                <option value="create-vmess">Vmess</option>
                                                <option value="create-vless">Vless</option>
                                                <option value="create-trojan">Trojan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="whatsapp" class="form-label">WhatsApp</label>
                                            <input type="number" class="form-control" id="whatsapp" name="whatsapp" placeholder="08123456789" onkeypress="return setNumber(event)" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="host" class="form-label">Host/IP</label>
                                            <input type="text" class="form-control" id="host" name="host" placeholder="domain.com" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expired" class="form-label">Expired</label>
                                            <input type="date" class="form-control" id="expired" name="expired" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="johndoe" required>
                                        </div>
                                        <div id="create-ssh">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="text" class="form-control" id="password" name="password" placeholder="**********" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="payload-cdn" class="form-label">Payload CDN</label>
                                                <textarea class="form-control" name="payload-cdn" id="payload-cdn" cols="50" rows="5" ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="payload-path" class="form-label">Payload Path</label>
                                                <textarea class="form-control" name="payload-path" id="payload-path" cols="50" rows="5" ></textarea>
                                            </div>
                                        </div>
                                        <div id="create-vmess">
                                            <div class="mb-3">
                                                <label for="vmess-uuid" class="form-label">UUID</label>
                                                <input type="text" class="form-control" id="vmess-uuid" name="vmess-uuid" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="vmess-tls" class="form-label">Config TLS</label>
                                                <textarea class="form-control" name="vmess-tls" id="vmess-tls" cols="50" rows="5" ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="vmess-ntls" class="form-label">Config None TLS</label>
                                                <textarea class="form-control" name="vmess-ntls" id="vmess-ntls" cols="50" rows="5" ></textarea>
                                            </div>
                                        </div>
                                        <div id="create-vless">
                                            <div class="mb-3">
                                                <label for="vless-uuid" class="form-label">UUID</label>
                                                <input type="text" class="form-control" id="vless-uuid" name="vless-uuid" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="vless-tls" class="form-label">Config TLS</label>
                                                <textarea class="form-control" name="vless-tls" id="vless-tls" cols="50" rows="5" ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="vless-ntls" class="form-label">Config None TLS</label>
                                                <textarea class="form-control" name="vless-ntls" id="vless-ntls" cols="50" rows="5" ></textarea>
                                            </div>
                                        </div>
                                        <div id="create-trojan">
                                            <div class="mb-3">
                                                <label for="key" class="form-label">Key</label>
                                                <input type="text" class="form-control" id="key" name="key" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="trojan-tls" class="form-label">Config TLS</label>
                                                <textarea class="form-control" name="trojan-tls" id="trojan-tls" cols="50" rows="5" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="send-create">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>