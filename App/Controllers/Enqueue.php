<?php

namespace App\Controllers;

if( ! defined('ABSPATH') ) exit();

class Enqueue
{
    
    public function enqueueList()
    {
        self::applyScripts();
        self::applyStyles();
    }

    public function applyScripts()
    {   
        wp_enqueue_script('js', plugins_url( '../../assets/js/jquery.js', __FILE__ ) );
        wp_enqueue_script('boostrap-js', plugins_url( '../../assets/js/slim.js', __FILE__ ) );
        wp_enqueue_script('boostrap-js', plugins_url( '../../assets/js/popper.js', __FILE__ ) );
        wp_enqueue_script('boostrap-js', plugins_url( '../../assets/js/bootstrap.bundle.js', __FILE__ ) );
        wp_enqueue_script('select2-js', plugins_url( '../../assets/js/select2.js', __FILE__ ) );
        wp_enqueue_script('custom-js', plugins_url( '../../assets/js/custom.js', __FILE__ ) );

    }

    public function applyStyles()
    {
        wp_enqueue_style('boostrap-css', plugins_url( '../../assets/css/bootstrap.css', __FILE__ ) );
        wp_enqueue_style('select2-css', plugins_url( '../../assets/css/select2.css', __FILE__ ) );
        
    }
}