<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class WPBE_EXPORT extends WPBE_EXT {

    protected $slug = 'export'; //unique
    private $exlude_keys = array('__checker'); //do not export
    private $csv_delimiter = ',';

    public function __construct() {
        add_action('wpbe_ext_scripts', array($this, 'wpbe_ext_scripts'), 1);

        //ajax
        add_action('wp_ajax_wpbe_export_posts_count', array($this, 'wpbe_export_posts_count'), 1);
        add_action('wp_ajax_wpbe_export_posts', array($this, 'wpbe_export_posts'), 1);

        //tabs
        $this->add_tab($this->slug, 'top_panel', esc_html('Export', 'bulk-editor'));
        add_action('wpbe_ext_top_panel_' . $this->slug, array($this, 'wpbe_ext_panel'), 1);
    }

    public function wpbe_ext_scripts() {
        wp_enqueue_script('wpbe_ext_' . $this->slug, $this->get_ext_link() . 'assets/js/' . $this->slug . '.js', [], WPBE_VERSION);
        wp_enqueue_style('wpbe_ext_' . $this->slug, $this->get_ext_link() . 'assets/css/' . $this->slug . '.css', [], WPBE_VERSION);
        ?>
        <script>
            lang.<?php echo $this->slug ?> = {};
            lang.<?php echo $this->slug ?>.want_to_export = '<?php esc_html_e('Should the export be started?', 'bulk-editor') ?>';
            lang.<?php echo $this->slug ?>.exporting = '<?php esc_html_e('Exporting', 'bulk-editor') ?> ...';
            lang.<?php echo $this->slug ?>.exported = '<?php esc_html_e('Exported', 'bulk-editor') ?> ...';
            lang.<?php echo $this->slug ?>.export_is_going = "<?php esc_html_e('ATTENTION: Export operation is going!', 'bulk-editor') ?>";

        </script>
        <?php
    }

    public function wpbe_ext_panel() {
        $data = array();
        $data['download_link'] = $this->get_ext_link() . '__exported_files/wpbe_exported.csv';
        $data['active_fields'] = $this->get_active_fields();
        echo WPBE_HELPER::render_html($this->get_ext_path() . 'views/panel.php', $data);
    }

    //ajax
    public function wpbe_export_posts_count() {
        if (!WPBE_HELPER::can_manage_data()) {
            return;
        }

        //***
        $active_fields = $this->get_active_fields();

        //***

        $this->csv_delimiter = $_REQUEST['csv_delimiter'];

        //***

        switch ($_REQUEST['format']) {
            case 'csv':

                if (!empty($active_fields)) {
                    $file_path = $this->get_ext_path() . '__exported_files/wpbe_exported.csv';
                    $fp = fopen($file_path, "w");
                    $titles = array();
                    $attribute_index = 1; //for attributes columns

                    foreach ($active_fields as $field_key => $field) {
                        if (!in_array($field_key, $this->exlude_keys)) {

                            switch ($field['field_type']) {
                                case 'meta':
                                    $titles[] = '"Meta: ' . $field_key . '"';
                                    break;

                                default:
                                    $titles[] = '"' . $field['title'] . '"'; //head titles
                                    break;
                            }
                        }
                    }

                    //***

                    $titles = implode($this->csv_delimiter, $titles);
                    fputs($fp, $titles . $this->csv_delimiter . PHP_EOL);
                    fclose($fp);
                }


                break;

            case 'excel':
                //todo
                break;
        }


        if (!isset($_REQUEST['no_filter'])) {
            //get count of filtered - doesn work if export is for checked posts
            $posts = $this->posts->gets(array(
                'fields' => 'ids',
                'no_found_rows' => true
            ));
            echo json_encode($posts->posts);
        }

        exit;
    }

    //ajax
    public function wpbe_export_posts() {
        if (!WPBE_HELPER::can_manage_data()) {
            wp_die('0');
        }

        //***

        $behavior = 1;
        if (isset($_REQUEST['behavior']) AND intval($_REQUEST['behavior']) == 0) {
            $behavior = 0;
        }

        $this->csv_delimiter = $_REQUEST['csv_delimiter'];

        $combination = array();
        if (isset($_REQUEST['combination'])) {
            $combination = $_REQUEST['combination'];
        }

        //***
        if (!empty($_REQUEST['posts_ids'])) {
            switch ($_REQUEST['format']) {
                case 'csv':
                    $file = $this->get_ext_path() . '__exported_files/wpbe_exported.csv';
                    $fp = fopen($file, 'a+');
                    $posts_ids = array();

                    foreach ($_REQUEST['posts_ids'] as $post_id) {
                        $posts_ids[] = $post_id;
                        $post = $this->posts->get_post($post_id);
                    }

                    //***

                    foreach ($posts_ids as $post_id) {
                        fputcsv($fp, $this->get_post_fields($post_id, $this->get_active_fields()), $this->csv_delimiter);
                    }

                    fclose($fp);
                    break;

                case 'excel':
                    //todo
                    break;

                default:
                    break;
            }
        }


        wp_die('done');
    }

    private function get_post_fields($post_id, $fields) {
        $answer = array();
        if (!empty($fields)) {

            foreach ($fields as $field_key => $field) {
                if (!in_array($field_key, $this->exlude_keys)) {

                    $a = $this->filter_fields_vals($this->posts->get_post_field($post_id, $field_key), $field_key, $field, $post_id);

                    switch ($field['field_type']) {
                        case 'xxx':
                            //empty
                            break;
                        default:
                            if (is_array($a)) {
                                if (!empty($a)) {
                                    $titles = [];

                                    foreach ($a as $o) {
                                        if (is_object($o)) {
                                            $titles[] = $o->name;
                                        } else {
                                            $titles[] = $o;
                                        }
                                    }

                                    $answer[] = implode(',', $titles);
                                } else {
                                    $answer[] = '';
                                }
                            } else {
                                $answer[] = $a;
                            }

                            break;
                    }
                }
            }
        }

        return $answer;
    }

    //values replaces to the human words
    private function filter_fields_vals($value, $field_key, $field, $post_id) {
        switch ($field['field_type']) {
            case 'taxonomy':

                if (is_array($value) AND ! empty($value)) {
                    $tmp = array();
                    if (in_array($field['taxonomy'], array('post_type'))) {
                        foreach ($value as $term) {
                            $tmp[] = $term->slug;
                        }
                        $value = implode(',', $tmp);
                    } else {
                        foreach ($value as $term) {
                            $tmp[] = $term->term_id;
                        }
                    }
                } else {
                    $value = '';
                }

                break;

            case 'meta':
                //just especially for thumbnail only
                if ($field['edit_view'] == 'thumbnail') {
                    $image = wp_get_attachment_image_src($value, 'full');
                    if ($image) {
                        $value = $image[0];
                    }
                }

                if ($field['edit_view'] == 'meta_popup_editor') {
                    if (!empty($value)) {
                        $value = json_encode($value, JSON_HEX_QUOT | JSON_HEX_TAG);
                    }
                }

                break;

            case 'field':
                if ($field_key == 'post_parent') {
                    $value = intval($value);
                    if ($value > 0) {
                        $value = 'id:' . $value;
                    }
                }
                break;
        }

        return $value;
    }

    //**********************************************************************

    public function get_active_fields() {
        static $fields_observed = array(); //cache

        if (empty($fields_observed)) {
            $fields_observed = $this->settings->active_fields;
        }

        return $fields_observed;
    }

}
