<?php defined('ABSPATH') or die();

class NS_YOUTUBE_VIDEOS_CPT_admin
{

    public function __construct()
    {
        // Add language support
        add_action( 'admin_init', array( $this, 'ns_add_languages' ) );
        // Enqueue scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'ns_enqueue_css' ));
        // Create shortcode
        add_shortcode('prefix_video', array( $this,'ns_create_shortcode'));
    }

    /**
     * Add the text domain for plugin translation.
     */
    public function ns_add_languages() {
        load_plugin_textdomain( 'ns-youtube-videos-cpt', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

    /*
     * Enqueue styles
    */
    public function ns_enqueue_css()
    {
        wp_enqueue_style('NS_VIDEOS_CPT_styles_css', plugins_url('/../assets/css/NS_YOUTUBE_VIDEOS_CPT_styles.css', __FILE__), null, '1.0');
    }

    /*
    * Create a shortcode to display the videos
    */
    public function ns_create_shortcode($atts){

        $this->a = shortcode_atts( array(
            'id' => 'POST ID',
            'border_color' => '#3498db',
        ), $atts );

        return $this->ns_create_markup($this->a['id'],$this->a['border_color']);
    }


    public function ns_create_markup($videoID, $borderColor){

        $this->border_color = $borderColor;
        $this->videoID = $videoID;
        $this->videoTitle = get_the_title( $this->videoID);
        $this->videoSubtitle = get_post_meta( $this->videoID, '_videoSubtitle', true );
        $this->videoDesription = get_post_meta( $this->videoID, '_videoDesc', true );
        $this->videoType = get_post_meta( $this->videoID, '_videoType', true );
        $this->videoUrl = get_post_meta( $this->videoID, '_videoURL', true );

        ob_start();
        ?>

            <div class='ns-videos-main-container'>

              <div class='ns-video-container'>

                  <?php
                      switch ($this->videoType) {
                          case 'youtube':
                              echo '<iframe width="100%" src="'.$this->videoUrl.'" style="border:8px solid '.$this->border_color.' "></iframe>';
                              break;

                          case 'vimeo':
                                echo '<iframe width="100%" src="'.$this->videoUrl.'" style="border:8px solid '.$this->border_color.' "></iframe>';
                              break;

                          case 'dailymotion':
                                echo '<iframe width="100%" src="'.$this->videoUrl.'" style="border:8px solid '.$this->border_color.' "></iframe>';
                              break;
                      }
                  ?>

              </div>

              <div class="ns-text-container">

                <div class="ns-text-container-title"><h2><?php echo $this->videoTitle; ?></h2></div>

                <div class="ns-text-container-subtitle"><strong><?php echo $this->videoSubtitle; ?></strong></div>

                <div class="ns-text-container-description"><?php echo $this->videoDesription; ?></div>

              </div>

            </div>

        <?php

        return ob_get_clean();

     }// end markup funtion

}

new NS_YOUTUBE_VIDEOS_CPT_admin;
