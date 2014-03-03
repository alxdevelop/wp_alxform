<?php 

class Alxform_Widget extends WP_Widget
{
  
  function Alxform_Widget()
  {
    parent::WP_Widget(false, $name = "AlxForm"); 
  }

  function form($instance)
  {
    $title = "";
    if(isset($instance['title']))
    {
      $title = esc_attr($instance['title']);
    }
    ?>
      <p><label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title:') ?><input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo $title ?>" /></label></p>
  <?php 
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);

    return $instance; 
  }

  function widget($args, $instance)
  {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']); 
  ?>
    <?php echo $before_widget; ?>
      <?php if ($title)
        echo $before_title . $title . $after_title; ?>
      Hello World with widgets!
    <?php echo $after_widget; ?>
  <?php
  }

}

function alxform_widget_load()
{
  register_widget( 'Alxform_Widget' );
}

add_action('widgets_init', 'alxform_widget_load');
