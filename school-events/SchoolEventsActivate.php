<?php
/**
 * Class Activate
 * @package App
 */
if ( ! class_exists( 'Activate' ) ) {
	/**
	 * Class Activate
	 * @package App\Activate
	 */
	class SchoolEventsActivate {

		function __construct(){
			//echo "Activate";
		}


		public static function activate() {  

			global $table_prefix, $wpdb;

		    $tblname = 'schoolevents';
		    $wp_track_table = $table_prefix . "$tblname ";
		    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) {

		        $sql = "CREATE TABLE IF NOT EXISTS {$wp_track_table} (
		          `id` int(11) NOT NULL,
				  `churchschoolname` varchar(255) NOT NULL,
				  `churchschoolcity` varchar(255) NOT NULL,
				  `state` varchar(255) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `email` varchar(255) NOT NULL,
				  `phone` varchar(255) NOT NULL,
				  `eventname` varchar(255) NOT NULL,
				  `eventstart` date NOT NULL,
				  `eventend` date NOT NULL,
				  `onlinelink` text NOT NULL,
				  `message` longtext NOT NULL
		        );";

		        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		        dbDelta($sql);
		    }

		}

	}

}