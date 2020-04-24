<?php defined('ABSPATH') or die();

class NS_cpt_and_metaboxes
{
    public function __construct()
    {
        // Add CPT videos
        add_action('init',array( $this, 'custom_post_types'));
        // Add meta boxes
        add_action('add_meta_boxes',array( $this, 'ns_video_meta_box'));
        // Save meta boxes
        add_action('save_post_video',array( $this,'ns_save_video_meta_boxes'));
        // Add videos posts user capabilities
        add_action( 'admin_init', array( $this,'ns_add_videos_capabilities'),999);
    }

    /*
     * Custom Post Type Videos
    */
    public function custom_post_types() {

            $this->labels = array(
                'name'               => __( 'Videos'),
                'singular_name'      => __( 'Video'),
                'menu_name'          => __( 'Videos'),
                'name_admin_bar'     => __( 'Video'),
                'add_new'            => __( 'Add New'),
                'add_new_item'       => __( 'Add New video' ),
                'new_item'           => __( 'New video'),
                'edit_item'          => __( 'Edit video'),
                'view_item'          => __( 'View video'),
                'all_items'          => __( 'All videos'),
                'search_items'       => __( 'Search videos' ),
                'parent_item_colon'  => __( 'Parent videos:' ),
                'not_found'          => __( 'No videos found.'),
                'not_found_in_trash' => __( 'No videos found in trash.' )
            );

            $this->args = array(
                'labels'             => $this->labels,
                'description'        => __( 'Videos CPT'),
                'public'             => true,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => 5,
                'menu_icon'          => 'dashicons-video-alt',
                'supports'           => array( 'title', 'author' ),
                'map_meta_cap'        => true,
                'capabilities' => array(
                    'publish_posts' => 'publish_videos',
                    'edit_posts' => 'edit_videos',
                    'edit_others_posts' => 'edit_others_videos',
                    'delete_posts' => 'delete_videos',
                    'delete_others_posts' => 'delete_others_videos',
                    'read_private_posts' => 'read_private_videos',
                    'edit_post' => 'edit_video',
                    'delete_post' => 'delete_video',
                    'read_post' => 'read_video',
                  ),
                  'capability_type'     => array('video', 'videos'),


            );

            register_post_type( 'Video', $this->args );

    }

    /*
    * Add CPT user capabilities
    * https://3.7designs.co/blog/2014/08/restricting-access-to-custom-post-types-using-roles-in-wordpress/
    */

    public function ns_add_videos_capabilities(){

        // gets the role to add capabilities to
        $admin = get_role( 'administrator' );
        $editor = get_role( 'editor' );
    	 // replicate all the remapped capabilites from the custom post type lesson
        $caps = array(
        	'edit_video',
        	'edit_videos',
        	'edit_other_videos',
        	'publish_videos',
        	'edit_published_videos',
        	'read_videos',
        	'read_private_videos',
        	'delete_video'
        );
        // give all the capabilities to the administrator
        foreach ($caps as $cap) {
    	    $admin->add_cap( $cap );
        }
        // limited the capabilities to the editor or a custom role
        $editor->add_cap( 'edit_video' );
        $editor->add_cap( 'edit_videos' );
        $editor->add_cap( 'read_videos' );


    }

    /*
    * Add Meta Boxes for Videos
    */

    public function ns_video_meta_box()
    {

        add_meta_box('_videoSubtitle', __('Video subtitle'), array($this, 'ns_videos_cpt_subtitle'), 'video', 'normal', 'high');

        add_meta_box('_videoDesc', __('Video description'), array($this, 'ns_videos_cpt_description'), 'video', 'normal', 'high');

        add_meta_box('_videoType', __('Video type'), array($this, 'ns_videos_cpt_type'), 'video', 'normal', 'high');

        add_meta_box('_videoURL', __('Video URL'), array($this, 'ns_videos_cpt_url'), 'video', 'normal', 'high');

        add_meta_box('_displayshortcode', __('Shortcode'), array($this, 'ns_videos_cpt_shortcode'), 'video', 'side', 'low');

    }

    /*
    * Video's subtitle
    */

    public function ns_videos_cpt_subtitle()
    {
        global $post;
        $subtitle = get_post_meta($post->ID, '_videoSubtitle', true);
        echo "<input type='text' name='_videoSubtitle' value='" . $subtitle  . "' class='widefat'/>";
    }

    /*
    * Video's Description
    */

    public function ns_videos_cpt_description()
    {
        global $post;
        $desc = get_post_meta($post->ID, '_videoDesc', true);
        echo "<textarea name='_videoDesc' class='widefat' rows='10'>".$desc."</textarea>";
    }


    /*
    * Video's Type
    */

    public function ns_videos_cpt_type()
    {
        global $post;

        $videoType = get_post_meta($post->ID, '_videoType', true);

        echo "<select type='text' name='_videoType' value='" . $videoType  . "' class='widefat'>";
        echo "<option value='youtube'".selected( $videoType, 'youtube' )."'>Youtube Videos</option>";
        echo "<option value='vimeo'".selected( $videoType, 'vimeo' )."'>Vimeo Videos</option>";
        echo "<option value='dailymotion'".selected( $videoType, 'dailymotion' )."'>Dailymotion Videos</option>";
        echo "</select>";
    }

    /*
    * Video's ID
    */

    public function ns_videos_cpt_url()
    {
        global $post;

        // Get the ID if its already been entered
        $videoLink = get_post_meta($post->ID, '_videoURL', true);

        echo "<h4><strong>".__('URL videos examples:')."</strong></h4><br />";
        echo "<p><strong class='dashicons-before dashicons-video-alt3'> Youtube video: </strong><span>https://www.youtube.com/embed/uPb3i4r2J5Q</span></p><br />";
        echo "<p><strong class='dashicons-before dashicons-editor-video'> Vimeo video: </strong><span>https://player.vimeo.com/video/89300381</span></p><br />";
        echo "<p><strong class='dashicons-before dashicons-video-alt2'> Dailymotion video: </strong><span>https://www.dailymotion.com/embed/video/x3v7z2i</span></p><br />";
        echo "<input type='url' name='_videoURL' value='" . $videoLink  . "' class='widefat'/>";
        echo "<br />";
    }


    public function ns_videos_cpt_shortcode()
    {
        global $post;
        echo "<p>". __('Copy the shortcode and past it to a post or page alternative you can add this post by using the video icon on the page/post text editor toolbar.')."<br /></p>";
        echo "<input value='[prefix_video id=\"".$post->ID."\" border_color=\"#fff\"]' class='widefat'/>";
    }

    /*
    * Save custom meta
    */
    public function ns_save_video_meta_boxes()
    {
        global $post;

        //if( current_user_can('editor') || current_user_can('administrator') ) return;

        // Save video's type
        if( isset( $_POST['_videoType'] ) )
        {
            $this->type = esc_attr($_POST['_videoType']);
            update_post_meta( $post->ID, '_videoType', $this->type);
        }

        // Save video's subtitle
        if( isset( $_POST['_videoSubtitle'] ) )
        {
            $this->subtitle = esc_attr($_POST['_videoSubtitle']);
            update_post_meta( $post->ID, '_videoSubtitle', $this->subtitle);
        }

        // Save video's description
        if( isset( $_POST['_videoDesc'] ) )
        {
            $this->desc = esc_textarea( $_POST['_videoDesc']);
            update_post_meta( $post->ID, '_videoDesc', $this->desc );
        }

        // Save video's URL
        if( isset( $_POST['_videoURL'] ) )
        {
            $this->videoURL = esc_attr( $_POST['_videoURL']);

            switch ($this->type) {
                case 'youtube':
                        update_post_meta( $post->ID, '_videoURL', $this->videoURL );
                    break;

                case 'vimeo':
                        update_post_meta( $post->ID, '_videoURL', $this->videoURL );
                    break;

                case 'dailymotion':
                        update_post_meta( $post->ID, '_videoURL', $this->videoURL );
                    break;
            }


        }


    }

}
new NS_cpt_and_metaboxes;
