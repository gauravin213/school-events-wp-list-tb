<?php

/*
Plugin Name: School Events
Description: This is the School Events plugin
Author: Dev
Text Domain: school-events
*/

//prefix: School_Events

defined( 'ABSPATH' ) or die();

define( 'School_Events_VERSION', '1.0.0' );
define( 'School_Events_URL', plugin_dir_url( __FILE__ ) );
define( 'School_Events_PATH', plugin_dir_path( __FILE__ ) );


require_once 'SchoolEventsActivate.php';
require_once 'SchoolEventsDeactivate.php';
require_once 'includes/function.php';

if ( ! class_exists( 'School_Events' ) ) {

    /**
     * Class AuctionProperty
     */
    final class School_Events {

        public function activate() {
            SchoolEventsActivate::activate();
        }

        public function deactivate() {
            SchoolEventsDeactivate::deactivate();
        }

    }

}

if ( class_exists( 'School_Events' ) ) {

    $auction = new School_Events();
    register_activation_hook( __FILE__, [ $auction, 'activate' ] );
    register_deactivation_hook( __FILE__, [ $auction, 'deactivate' ] );

}









