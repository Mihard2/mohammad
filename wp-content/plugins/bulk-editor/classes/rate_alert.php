<?php

class WPBE_RATE_ALERT {

    protected $notes_for_free = true;

    public function __construct($for_free) {
        $this->notes_for_free = $for_free;
    }

    public function init() {
        if (is_admin()) {

            global $wp_version;
            if (version_compare($wp_version, '4.2', '>=')) {
                $hide_alert = get_option('wpbe_rate_alert', 0);

                if (!$hide_alert) {
                    $alert = intval(get_option('wpbe_alert_rev', 0));

                    if (!$alert) {
                        update_option('wpbe_alert_rev', time());
                        $alert = time();
                    }

                    if (time() >= ($alert + 86400 * 7)) {//7 days
                        add_action('admin_notices', array($this, 'wpbe_alert'));
                        add_action('network_admin_notices', array($this, 'wpbe_alert'));
                        add_action('wp_ajax_wpbe_dismiss_rate_alert', array($this, 'wpbe_dismiss_alert'));
                    }
                }
            }
        }
    }

    function wpbe_alert() {

        if (isset($_GET['page']) AND $_GET['page'] == 'wpbe') {
            $support_link = 'https://pluginus.net/support/forum/wpbe-wordpress-posts-bulk-editor-professional/';
            ?>
            <div class="notice notice-warning is-dismissible" id="wpbe_rate_alert" data-nonce="<?php echo json_encode(wp_create_nonce('wpbe_dissmiss_rate_alert')) ?>">
                <p class="plugin-card-woocommerce-currency-switcher">
                    <?php printf(__("Hello! Looks like you using <b>Bulk Editor</b> for some time and I hope this software helped you with your business. If you happy with the plugin functionality and like Bulk Editor - rate please WPBE with 5-stars, also share your opinion and ideas with us. Thank you!<br /> P.S. If you have troubles you can always ask %s about help.", 'bulk-editor'), "<a href='{$support_link}' target='_blank'>" . __('support', 'bulk-editor') . "</a>") ?>
                </p>

                <hr />

                <?php
                $link = 'https://codecanyon.net/downloads#item-24376112';
                if ($this->notes_for_free) {
                    $link = 'https://wordpress.org/plugins/bulk-editor/reviews/#new-post';
                }
                ?>


                <table style="width: 100%; margin-bottom: 7px;">
                    <tr>
                        <td style="width: 33%; text-align: center;">
                            <a href="<?= $link ?>" target="_blank" class="wpbe-panel-button dashicons-before dashicons-star-filled">&nbsp;<?php echo __('Write marvellous review about WPBE features', 'bulk-editor') ?></a>
                        </td>

                        <td style="width: 33%; text-align: center;">
                            <a href="javascript: jQuery('#wpbe_rate_alert .notice-dismiss').trigger('click');void(0);" class="button button-large dashicons-before dashicons-thumbs-up">&nbsp;<?php echo __('It is done!', 'bulk-editor') ?></a>
                        </td>

                        <td style="width: 33%; text-align: center;">
                            <a href="https://pluginus.net/support/forum/wpbe-wordpress-posts-bulk-editor-professional/" target="_blank" class="wpbe-panel-button dashicons-before dashicons-hammer"><?php echo __('Bulk Editor SUPPORT', 'bulk-editor') ?></a>
                        </td>
                    </tr>
                </table>


            </div>
            <script>
                jQuery(function ($) {
                    var alert_w = $('#wpbe_rate_alert');
                    alert_w.on('click', '.notice-dismiss', function (e) {
                        //e.preventDefault 

                        $.post(ajaxurl, {action: 'wpbe_dismiss_rate_alert',
                            sec: <?php echo json_encode(wp_create_nonce('wpbe_dissmiss_rate_alert')) ?>
                        });
                    });
                });
            </script>

            <?php
        }
    }

    public function wpbe_dismiss_alert() {
        check_ajax_referer('wpbe_dissmiss_rate_alert', 'sec');

        add_option('wpbe_rate_alert', 1, '', 'no');
        update_option('wpbe_rate_alert', 1);

        exit;
    }

}
