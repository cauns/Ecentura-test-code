<?php
class Amphibious_Child_Widget extends WP_Widget {

    private  $sortArray = [
        'name'=>'Name',
        'post_date'=>'Date'
    ];

    function __construct() {
        $tpwidget_options = array(
            'classname' => 'amphibious_child_class', 
            'description' => 'amphibious child widget example '
        );
        $this->WP_Widget('amphibious_child_id', 'Amphibious Child Widget', $tpwidget_options);
    }

    
    function form( $instance ) {

       
        $default = array(
            'title' => 'Title',
            'category'=>'Category',
            'sort'=>'Sort category'
        );

        
        $instance = wp_parse_args( (array) $instance, $default);

        
        $title = esc_attr( $instance['title'] );
        $catId= esc_attr( $instance['category'] );
        $sort= esc_attr( $instance['sort'] );
        
        echo "<p>Title<input type='text' class='widefat' name='".$this->get_field_name('title')."' value='".$title."' /></p>";
        $args = array(
            'type'      => 'post',
            'child_of'  => 0,
            'parent'    => ''
        );
        $categories = get_categories($args);
        $select = '<p>Select category';
        $select .= "<select name='".$this->get_field_name('category')."' class='widefat'>";
        foreach( $categories as $category ) {
            if($catId == $category->term_id) {
                $select .= "<option value='" . $category->term_id . "' selected>" . $category->name . "</option>";
            }else{
                $select .= "<option value='" . $category->term_id . "'>" . $category->name . "</option>";
            }
        }
        $select .= "</select>";
        echo $select;

        $sortHtml = '<p>Choose type sort category';
        $sortHtml .= "<select name='".$this->get_field_name('sort')."' class='widefat'>";
        foreach ($this->sortArray as $key => $item){
            if($key == $sort) {
                $sortHtml .= "<option value='" . $key . "' selected>" . $item . "</option>";
            }else{
                $sortHtml .= "<option value='" . $key . "'>" . $item . "</option>";
            }
        }
        $sortHtml .= "</select>";
        echo $sortHtml;

    }

    /**
     * save widget form
     */

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['sort'] = strip_tags($new_instance['sort']);
        return $instance;
    }

    /**
     * Show widget
     */

    function widget( $args, $instance ) {

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $catId = $instance['category'];
        $sort = $instance['sort'];

        echo $before_widget;

        
        echo $before_title.$title.$after_title;

        $postArgs = [
            'category'         => $catId,
            'orderby'          => $sort,
            'numberposts'      => 1000,
        ];
        $posts = get_posts($postArgs);
        echo "<ul>";
        foreach ($posts as $post){
            echo "<li>".$post->post_title."</li>";
        }
        echo "</ul>";

        echo "ABC XYZ";

      

        echo $after_widget;
    }

}


add_action( 'widgets_init', 'create_amphibious_child_widget' );
function create_amphibious_child_widget() {
    register_widget('Amphibious_Child_Widget');
}