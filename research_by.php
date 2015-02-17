<?php
/*
Plugin Name: Ricerca vacanze in barca
Description: Custom widget per la ricerca di barche a noleggio nel portale Barcheyacht.it.
Version: 1.8
*/

/* Start Adding Functions Below this Line */

// Creating the widget
function aggiunta_script() { 
  // moment.js for the date functions
  wp_register_script( 'moment', plugin_dir_url(__FILE__) . 'js/moment.min.js', '', null, false);
  wp_register_script( 'moment-lang-it', plugin_dir_url(__FILE__) . 'js/moment-it.js', '', null, false);
  // core javascript
  wp_register_script( 'ricerca-by', plugin_dir_url(__FILE__) . 'js/research.js', array('jquery'), null, false);
  // modernizr for better cross-browser compatibility
  wp_register_script( 'modernizr-cust', plugin_dir_url(__FILE__) . 'js/modernizr.custom.79639.js', '', null, false);

  wp_enqueue_script( 'moment' );
  wp_enqueue_script( 'moment-lang-it' ); 
  wp_enqueue_script( 'ricerca-by' ); 
  wp_enqueue_script( 'modernizr-cust' ); 
}

add_action( 'wp_enqueue_scripts', 'aggiunta_script' );

function load_css() {
    wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Roboto:400,500');
    // search icon
    wp_register_style('fontAwesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
    // core css style
    wp_register_style('ricerca-by-style', plugin_dir_url(__FILE__) . 'css/style.css');

    wp_enqueue_style('googleFonts');
    wp_enqueue_style('fontAwesome');
    wp_enqueue_style('ricerca-by-style');
}
    
add_action('wp_print_styles', 'load_css');

class wpb_widget extends WP_Widget {

  function __construct() {
    parent::__construct(
// Base ID of your widget
      'wpb_widget', 

// Widget name will appear in UI
      __('Ricerca Barcheyacht.it', 'wpb_widget_domain'), 

// Widget description
      array( 'description' => __( 'Widget di ricerca su Barcheyacht.it', 'wpb_widget_domain' ), ) 
      );
  }

// Creating widget front-end
// This is where the action happens
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
    echo $args['before_widget'];
    echo '<div class="wrapper-by">';
    if ( ! empty( $title ) )
      echo '<div class="by-title">' . $title . '</div>';

// This is where you run the code and display the output
    $testo = '<div data-val="" class="wrapper-dropdown-by by_dove" tabindex="1">
            <span class="by_icona">&nbsp;</span>
            <span class="by_txt">Dove vuoi andare?</span>
            <span class="by_caret">&gt;</span>
            <ul class="by_dropdown">
            </ul>
            <span class="by_tri">&nbsp;</span>
          </div>
          <div data-val="" class="wrapper-dropdown-by by_barca" tabindex="2">
            <span class="by_icona">&nbsp;</span>
            <span class="by_txt">Con che barca?</span>
            <span class="by_caret">&gt;</span>
            <ul class="by_dropdown">
              <li data-val="motore"><a href="#">Motore</a></li>
              <li data-val="vela"><a href="#">Vela</a></li>
            </ul>
            <span class="by_tri">&nbsp;</span>
          </div>
          <div data-val="" class="wrapper-dropdown-by by_quando" tabindex="3">
            <span class="by_icona">&nbsp;</span>
            <span class="by_txt">In che periodo?</span>
            <span class="by_caret">&gt;</span>
            <ul class="by_dropdown">
            </ul>
            <span class="by_tri">&nbsp;</span>
          </div>
          <div data-val="" class="wrapper-dropdown-by by_quanti" tabindex="4">
            <span class="by_icona">&nbsp;</span>
            <span class="by_txt">Quanti siete?</span>
            <span class="by_caret">&gt;</span>
            <ul class="by_dropdown">
              <li data-val="da_1_a_12"><a href="#">1</a></li>
              <li data-val="da_2_a_12"><a href="#">2</a></li>
              <li data-val="da_3_a_12"><a href="#">3</a></li>
              <li data-val="da_4_a_12"><a href="#">4</a></li>
              <li data-val="da_5_a_12"><a href="#">5+</a></li>
            </ul>
            <span class="by_tri">&nbsp;</span>
          </div>
          <div class="by_cerca"><a href="#">CERCA<i class="fa fa-search">&nbsp;</i></a></div>
          <div class="by_power">powered by <a href="http://www.bluewago.it" target="_blank">Barcheyacht.it</a></div>
        </div>';
        
echo __($testo, 'wpb_widget_domain' );
echo $args['after_widget'];
}

// Widget Backend 
public function form( $instance ) {
  if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
  }
  else {
    $title = __( 'Titolo', 'wpb_widget_domain' );
  }
// Widget admin form
  ?>
  <p>
    <label for='<?php echo $this->get_field_id( 'title' ); ?>'><?php _e( 'Title:' ); ?></label> 
    <input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo esc_attr( $title ); ?>' />
  </p>
  <?php 
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

/* Stop Adding Functions Below this Line */
?>
