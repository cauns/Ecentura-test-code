<?php

function widgetsInit() {
    register_sidebar( array(
        'name'          => 'Footer',
        'id'            => 'widget_footer',
        'before_widget' => '<div id="%1$s" class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ) );
    register_sidebar( array(
        'name'          => 'Footer top',
        'id'            => 'widget_footer_top',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ) );
}
add_action( 'widgets_init', 'widgetsInit' );
 
 // add metabox option with slogin textbox

function amphibious_child_meta_box()
{
 add_meta_box( 'option', 'Options', 'amphibious_child_option_output', 'post' );
}
add_action( 'add_meta_boxes', 'amphibious_child_meta_box' );
 

function amphibious_child_option_output( $post )
{
 $slogan = get_post_meta( $post->ID, '_slogan', true );
 
 echo ( '<label for="slogan">Slogan: </label>' );
 echo ('<input type="text" id="slogan" name="slogan" value="'.esc_attr( $slogan ).'" />');
}
 

function amphibious_child_option_save( $post_id )
{
 $slogan = sanitize_text_field( $_POST['slogan'] );
 update_post_meta( $post_id, '_slogan', $slogan );
}
add_action( 'save_post', 'amphibious_child_option_save' );

if ( ! function_exists( 'amphibious_entry_footer' ) ) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function amphibious_entry_footer() {
        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( _x(', ', 'Used between category, there is a space after the comma.', 'amphibious' ) );
            if ( $categories_list && amphibious_categorized_blog() ) {
                /* translators: %s: posted in categories */
                printf( '<span class="cat-links cat-links-single">' . esc_html__( 'Posted in %1$s', 'amphibious' ) . '</span>', wp_kses_post( $categories_list ) );
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', _x(', ', 'Used between tag, there is a space after the comma.', 'amphibious' ) );
            if ( $tags_list ) {
                /* translators: %s: posted in tags */
                printf( '<span class="tags-links tags-links-single">' . esc_html__( 'Tagged %1$s', 'amphibious' ) . '</span>', wp_kses_post( $tags_list ) );
            }
            global $post;
            $customSlogan = get_post_meta( $post->ID, '_slogan', true );

            printf( '<span class="tags-links tags-links-single">' . esc_html__( '%1$s', 'amphibious' ) . '</span>', $customSlogan);
        }

        /* translators: %s: post title */
        edit_post_link( sprintf( esc_html__( 'Edit %1$s', 'amphibious' ), '<span class="screen-reader-text">' . the_title_attribute( 'echo=0' ) . '</span>' ), '<span class="edit-link">', '</span>' );
    }
endif;

function themeslug_customize_register( $wp_customize ) {
    $wp_customize->add_setting ( 'amphibious_copyright1', array (
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'wp_kses_post',
    ) );

    $wp_customize->add_control ( 'amphibious_copyright1', array (
        'label'    => esc_html__( 'Copyright1', 'amphibious' ),
        'section'  => 'amphibious_footer_options',
        'priority' => 3,
        'type'     => 'textarea',
    ) );
}
add_action( 'customize_register', 'themeslug_customize_register' );


include('extends/widget.php');


add_action( 'init', 'remove_custom_1' );
// Remove the 'add_My_Meta_Tags' function from the wp_head action hook
function remove_custom_1()
{
    remove_action( 'amphibious_credits', 'amphibious_credits_blog' );
}
function amphibious_credits_blog_1() {
    // Blog Credits HTML
    $html = '<div class="credits credits-blog">'. get_theme_mod( 'amphibious_copyright1' ) .'</div>';

    // Convert Chars
    $html = convert_chars( convert_smilies( wptexturize( stripslashes( wp_filter_post_kses( addslashes( $html ) ) ) ) ) );

    // Sanitization
    echo wp_kses_post( $html );
}
add_action( 'amphibious_credits', 'amphibious_credits_blog_1' );
add_action( 'admin_init', 'my_settings_init' );

function amphibious_child_settings_page()
{
    add_settings_field("amphibious-child-woo-email-send", "Send Email", "amphibious_child_checkbox_display", "general");
    register_setting("section", "amphibious-child-woo-email-send");
}

function amphibious_child_checkbox_display()
{
    ?>
    <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
    <input type="checkbox" name="amphibious-child-woo-email-send" value="1" <?php checked(1, get_option('amphibious-child-woo-email-send'), true); ?> />
    <?php
}

add_action("admin_init", "amphibious_child_settings_page");