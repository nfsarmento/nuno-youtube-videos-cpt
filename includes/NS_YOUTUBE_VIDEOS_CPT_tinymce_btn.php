<?php defined('ABSPATH') or die();

class YOUTUBE_VIDEOS_CPT_tinymce_btn
{
    private $videosPosts;

    public function __construct()
    {
        $this->videosPosts = get_posts(array('post_type'=>'video'),OBJECT);

        add_action('init',array($this, 'ns_shortcode_btn_init'));

        foreach ( array('post.php','post-new.php') as $videoHook ) {
            add_action( "admin_head-$videoHook", array($this,'ns_my_admin_head' ));
        }

    }

    public function ns_shortcode_btn_init(){
        add_filter("mce_external_plugins", array($this,"ns_enqueue_plugin_scripts"));
        add_filter("mce_buttons", array($this,"ns_register_buttons_editor"));
    }

    public function ns_enqueue_plugin_scripts($plugin_array)
    {
        $plugin_array["video_tinymce_button_js"] = plugin_dir_url( __FILE__ ) .  "../assets/js/NS_YOUTUBE_VIDEOS_CPT_shortcode.js";
        return $plugin_array;
    }

	public function ns_register_buttons_editor($buttons)
    {
        array_push($buttons, "video_tinymce_button");
        return $buttons;
    }

    public function ns_my_admin_head() {
        ?>
        <script type='text/javascript'>
            var tinymce_btn_plugin = {
                'videos': '<?php echo json_encode( $this->videosPosts); ?>',
            };
        </script>
        <?php
    }

}
new YOUTUBE_VIDEOS_CPT_tinymce_btn;
