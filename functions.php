<?php

/* 
    My theme function
*/

// Theme Title
add_theme_support('title-tag');


// Theme CSS and Jquery file calling
function sk_css_js_call(){
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
    wp_register_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css', array(), '3.4.1', 'all');
    wp_register_style('custom', get_template_directory_uri().'/css/custom.css', array(), '1.0.0', 'all');
    wp_enqueue_style('bootstrap');
    wp_enqueue_style('custom');

    // Jquery
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.js', array(), '3.4.1', 'true');
    wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array(), '1.0.0', 'true');

}
add_action('wp_enqueue_scripts', 'sk_css_js_call');

// Google font enqueue
function sk_add_google_font(){
    wp_enqueue_style( 'sk_google_fonts', 'https://fonts.googleapis.com/css2?family=Oswald&display=swap', false);
}
add_action('wp_enqueue_scripts', 'sk_add_google_font');

// Theme function
function sk_customizer_register($wp_customize){

    // Header Section Area

    $wp_customize->add_section('sk_header_area', array(
        'title' => __('Header Area', 'skkamal'),
        'description' => 'If you want to update your logo you can update here'
    ));

    $wp_customize->add_setting('update_logo', array(
        'default' => get_bloginfo('template_directory') . '/img/logo.png',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'update_logo', array(
        'lebel' => 'Logo Upload',
        'description' => 'If you interest to update your logo you can do it here',
        'setting' => 'update_logo',
        'section' => 'sk_header_area',
    ) ));

    // Menu Position Area

    $wp_customize->add_section('sk_menu_position', array(
        'title' => __('Menu Position Option', 'skkamal', ),
        'description' => 'If you interest to update your menu position you can do it here',
    ));

    $wp_customize->add_setting('update_menu_position', array(
        'default' => 'right_menu',
    ));

    $wp_customize->add_control('update_menu_position', array(
        'lebel' => 'Menu Position Change',
        'description' => 'If you interest to update your menu position you can do it here',
        'setting' => 'update_menu_position',
        'section' => 'sk_menu_position',
        'type' => 'radio',
        'choices' => array(
            'left_menu' => 'Left Menu',
            'right_menu' => 'Right Menu',
            'center_menu' => 'Center Menu',
        ),
    ));
}
add_action('customize_register', 'sk_customizer_register');


// Menu Register

register_nav_menu( 'main_menu', __('Main Menu', 'skkamal'));

// Walker Menu Propertise

function sk_nav_description($item_output, $item, $args){
    if( !empty ($item->description) ){
        $item_output = str_replace($args->link_after . '</a>', '<span class="walker_nav">' . $item->description . '</span>' . $args-> link_after . '</a>', $item_output);
    }

    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'sk_nav_description', 10, 3);