<?php
/*
Plugin Name: Ricerca Barcheyacht.it
Description: Custom widget per la ricerca su Barcheyacht.it. Non viene fornito alcun supporto dallo sviluppatore.
Version: 0.3
*/
/* Start Adding Functions Below this Line */

// Creating the widget 
function aggiunta_script() { 
  wp_register_script( 'moment', plugin_dir_url(__FILE__) . 'moment.min.js', '', null, false);
  wp_register_script( 'moment-lang', plugin_dir_url(__FILE__) . 'lang/it.js', '', null, false);
  wp_register_script( 'ricerca', plugin_dir_url(__FILE__) . 'research.js', array('jquery'), null, false);

  wp_enqueue_script( 'moment' );
  wp_enqueue_script( 'moment-lang' ); 
  wp_enqueue_script( 'ricerca' ); 
}

add_action( 'wp_enqueue_scripts', 'aggiunta_script' );

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
    $checkboxL = $instance['checkboxL'] ? 'true' : 'false';

// before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
    echo "<style type='text/css'>
  .bywidget {width: 90%; margin-left: auto; margin-right: auto; text-align: center;}
  .bywidget li { height: 27px; }
  .bylogo { margin-bottom: 5px; }
  .bywidget select { width: 100%; margin-bottom: 5px; }
  </style>";

    echo "<div class='bywidget'>";
    $logo = "<img class='bylogo' src='" . plugin_dir_url(__FILE__) . "logo.png'></img>";

    if ($checkboxL) echo $logo;
    
    $testo = "<ul><li>
    <select id='by_dove' name='dove' class='input-xlarge'>
      <option value=''>Dove vuoi andare?</option>   
    </select>
  </li>

  <li>
    <select id='by_tipo' name='tipo' class='input-xlarge'>
      <option value=''>Con che imbarcazione?</option>
      <option value='motore'>Motore</option>
      <option value='vela'>Vela</option>
    </select>
  </li>

  <li>
    <select id='by_periodo' name='periodo' class='input-xlarge'>
      <option value=''>In che periodo?</option>
    </select>
  </li>

  <li>  
    <select id='by_posti_letto' name='posti_letto' class='input-xlarge'>
      <option value=''>Quanti siete?</option>
      <option value='da_1_a_12'>1</option>
      <option value='da_2_a_12'>2</option>
      <option value='da_3_a_12'>3</option>
      <option value='da_4_a_12'>4</option>
      <option value='da_5_a_12'>5+</option>
    </select>
  </li>

  <li>
    <!-- <div class='friendly_button friendly_button_medium friendly_button_black friendly_button_less_round friendly_button_none'> -->
      <button style='margin: 0 auto; cursor: pointer;' id='by_cerca' >Cerca</button>
   <!-- </div> -->
  </li></ul>
</div>";
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
  <p>
    <input class="checkboxL" type="checkbox" <?php checked($instance['checkboxL'], 'on'); ?> id="<?php echo $this->get_field_id('checkboxL'); ?>" name="<?php echo $this->get_field_name('checkboxL'); ?>" /> 
    <label for="<?php echo $this->get_field_id('checkboxL'); ?>">Logo</label>
  </p>
  <?php 
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  $instance['checkboxL'] = $new_instance['checkboxL'];
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
