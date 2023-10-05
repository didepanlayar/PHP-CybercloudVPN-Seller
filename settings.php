<?php

require_once 'includes/session.php';

get_session();

$title = 'Settings';

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
                                            <label for="site-title" class="form-label">Site Title</label>
                                            <input type="text" class="form-control" id="site-title" name="site-title"
                                                placeholder="Cybercloud VPN Seller" required value="<?php echo isset($data['sitetitle']) ? $data['sitetitle'] : ''; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="display-name" class="form-label">Display Name</label>
                                            <input type="text" class="form-control" id="display-name" name="display-name" placeholder="Cybercloud VPN" required value="<?php echo isset($data['sitename']) ? $data['sitename'] : ''; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="site-address" class="form-label">Site Address (URL)</label>
                                            <input type="text" class="form-control" id="site-address" name="site-address" placeholder="https://cybercloudvpn.com" required value="<?php echo isset($data['siteurl']) ? $data['siteurl'] : ''; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="whatsapp" class="form-label">WhatsApp Token</label>
                                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" required value="<?php echo isset($data['watoken']) ? $data['watoken'] : ''; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="wachatid" class="form-label">WhatsApp Chat ID</label>
                                            <input type="text" class="form-control" id="wachatid" name="wachatid" required value="<?php echo isset($data['wachatid']) ? $data['wachatid'] : ''; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="telegram" class="form-label">Telegram Token</label>
                                            <input type="text" class="form-control" id="telegram" name="telegram" required value="<?php echo isset($data['tgtoken']) ? $data['tgtoken'] : ''; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tgchatid" class="form-label">Telegram Chat ID</label>
                                            <input type="text" class="form-control" id="tgchatid" name="tgchatid" required value="<?php echo isset($data['tgchatid']) ? $data['tgchatid'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="save-settings">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>