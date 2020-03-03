<?php

defined( 'ABSPATH' ) || exit;

//my_wp_list_table_{table_name} like  school_events  school-events 

add_action( 'admin_menu', 'school_events_admin_menu_page_fun');
function school_events_admin_menu_page_fun(){

    $title = "School events";
    $hook = add_menu_page( $title, $title, 'manage_options', 'school-events', 'school_events_admin_menu_fun');

    add_action( "load-$hook", 'school_events_add_option');

}

function school_events_admin_menu_fun(){

    global $wpdb;
?>  
<div class="wrap">

<?php
if ($_GET['action'] == 'add') {
        ?>
        <h2><?php _e( 'Add Schoolevents', 'school-events-funds' ); ?></h2>
        <form id="form_school_events" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="postbox-container-2" class="postbox-container">
                        <!--normal-->
                       <?php do_meta_boxes("school-events-add-form", "normal", null); ?>
                    </div>
                    <div id="postbox-container-1" class="postbox-container">
                        <!--side-->
                        <?php do_meta_boxes("school-events-submit-btn", "side", null); ?>
                    </div>
                </div>
                <br class="clear" />
            </div>
        </form>
        <?php
       
    }else if ($_GET['action'] == 'edit') {

        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}schoolevents WHERE ID=".$_GET['customer']);
       
        ?>
        <h1 class="wp-heading-inline"><?php _e( 'Edit Schoolevents', 'school-events-funds' ); ?></h1>
        <a href="<?php echo admin_url();?>admin.php?page=school-events&action=add" class="page-title-action">
            <?php _e( 'Add New', 'school-events-funds' ); ?></a>
        <hr class="wp-header-end">
        <form id="form_school_events" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="postbox-container-2" class="postbox-container">
                        <!--normal-->
                       <?php do_meta_boxes("school-events-edit-form", "normal", $result); ?>
                    </div>
                    <div id="postbox-container-1" class="postbox-container">
                        <!--side-->
                        <?php do_meta_boxes("school-events-submit-btn", "side", $result); ?>
                    </div>
                </div>
                <br class="clear" />
            </div>
        </form>
        <?php

       
    }else{

        $exampleListTable = new SchoolEvents();
        ?>
        <h1 class="wp-heading-inline"><?php _e( 'Schoolevents', 'school-events-funds' ); ?></h1>
        <a href="<?php echo admin_url();?>admin.php?page=school-events&action=add" class="page-title-action"><?php _e( 'Add New', 'school-events-funds' ); ?></a>
        <a href="<?php echo admin_url( 'admin-post.php?action=School_EventsExportData&tb_name=schoolevents' ); ?>" class="page-title-action">Export</a>
        <hr class="wp-header-end">
        <form id="school_events_form" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php
            $exampleListTable->prepare_items();
            $exampleListTable->views();
            $exampleListTable->search_box("Search Post(s)", "search_post_id");
            $exampleListTable->display(); 
            ?>
        </form>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#name_filter').select2({placeholder : "select me" });
                jQuery('#city_filter').select2({placeholder : "select me" });
            });
        </script>
        <?php

    }
?>
       
</div>
<div class="clear"></div>
<script type="text/javascript">
jQuery(document).ready(function($){
    jQuery(".if-js-closed").removeClass("if-js-closed").addClass("closed");
    postboxes.add_postbox_toggles( pagenow );
});
</script>
<?php
}

function school_events_edit_form_fun($result){

    $churchschoolname = $result[0]->churchschoolname;
    $churchschoolcity = $result[0]->churchschoolcity;
    $state = $result[0]->state;
    $name = $result[0]->name;
    $email = $result[0]->email;
    $phone = $result[0]->phone;
    $eventname = $result[0]->eventname;
    $eventstart = $result[0]->eventstart;
    $eventend = $result[0]->eventend;
    $onlinelink = $result[0]->onlinelink;
    $message = $result[0]->message;

   ?>
   
    <div class="form_field">
        <label><strong><?php _e( 'Churchschoolname', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="churchschoolname" placeholder="churchschoolname" value="<?php echo $churchschoolname?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Churchschoolcity', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="churchschoolcity" placeholder="churchschoolcity" value="<?php echo $churchschoolcity?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'State', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="state" placeholder="state" value="<?php echo $state?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Name', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="name" placeholder="name" value="<?php echo $name?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Email', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="email" placeholder="email" value="<?php echo $email?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Phone', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="phone" placeholder="phone" value="<?php echo $phone?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Eventname', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="eventname" placeholder="eventname" value="<?php echo $eventname?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Eventstart', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="eventstart" placeholder="eventstart" value="<?php echo $eventstart?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Eventend', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="eventend" placeholder="eventend" value="<?php echo $eventend?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Onlinelink', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="onlinelink" placeholder="onlinelink" value="<?php echo $onlinelink?>" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Message', 'school-events-funds' ); ?></strong></label>
        <!-- <input type="text" name="message" placeholder="message" value="<?php echo $message?>" class="large-text">  -->
        <textarea name="message" class="large-text"><?php echo $message?></textarea>
    </div>

    <input type="hidden" name="customer" value="<?php echo $_GET['customer'];?>">

    <input type="hidden" name="mode" value="edit">

    <input type="hidden" name="action" value="school_events_Form_Action">
   <?php

}

function school_events_submit_btn_fun(){
    ?>
    <button name="btn_smt" class="button button-primary button-large">Submit</button>
    <?php
}


function school_events_add_form_fun(){

    ?>
    <div class="form_field">
        <label><strong><?php _e( 'Churchschoolname', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="churchschoolname" placeholder="churchschoolname" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Churchschoolcity', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="churchschoolcity" placeholder="churchschoolcity" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'State', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="state" placeholder="state" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Name', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="name" placeholder="name" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Email', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="email" placeholder="email" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Phone', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="phone" placeholder="phone" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Eventname', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="eventname" placeholder="eventname" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Eventstart', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="eventstart" placeholder="eventstart" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Eventend', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="eventend" placeholder="eventend" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Onlinelink', 'school-events-funds' ); ?></strong></label>
        <input type="text" name="onlinelink" placeholder="onlinelink" value="" class="large-text"> 
    </div>

    <div class="form_field">
        <label><strong><?php _e( 'Message', 'school-events-funds' ); ?></strong></label>
       <!--  <input type="text" name="message" placeholder="message" value="" class="large-text">  -->
       <textarea name="message" class="large-text"></textarea>
    </div>

    <input type="hidden" name="action" value="school_events_Form_Action">

    <input type="hidden" name="mode" value="add">
    <?php
}

function school_events_add_option() {

    add_meta_box("school-events-edit-form", "Schoolevents", "school_events_edit_form_fun", "school-events-edit-form", "normal");

    add_meta_box("school-events-add-form", "Schoolevents", "school_events_add_form_fun", "school-events-add-form", "normal");

    add_meta_box("school-events-submit-btn", "Publish", "school_events_submit_btn_fun", "school-events-submit-btn", "side");

    $option = 'per_page';
 
	$args = array(
	    'label' => 'Customer',
	    'default' => 10,
	    'option' => 'customer_list_per_page'
	);
	 
	add_screen_option( $option, $args );

    $exampleListTable = new SchoolEvents();


}


add_filter('set-screen-option', 'school_events_set_option', 10, 3);
 
function school_events_set_option($status, $option, $value) {
 
    if ( 'customer_list_per_page' == $option ) return $value;
 
    return $status;
 
}


add_action('admin_post_school_events_Form_Action', 'school_events_Form_Action');
add_action('admin_post_nopriv_school_events_Form_Action', 'school_events_Form_Action');
function school_events_Form_Action(){

    global $wpdb;

    if ($_POST['mode'] == 'add') { 

        $churchschoolname = $_POST['churchschoolname'];
        $churchschoolcity = $_POST['churchschoolcity'];
        $state = $_POST['state'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $eventname = $_POST['eventname'];
        $eventstart = $_POST['eventstart'];
        $eventend = $_POST['eventend'];
        $onlinelink = $_POST['onlinelink'];
        $message = $_POST['message'];


        $q = "INSERT INTO `{$wpdb->prefix}schoolevents`      
               (churchschoolname, churchschoolcity, state, name, email, phone, eventname, eventstart, eventend, onlinelink, message)
        values ('".$churchschoolname."', '".$churchschoolcity."', '".$state."', '".$name."', '".$email."', '".$phone."', '".$eventname."', '".$eventstart."', '".$eventend."', '".$onlinelink."', '".$message."')";

        $sql = $wpdb->prepare($q);
        $wpdb->query($sql);


        $lastid = $wpdb->insert_id;  

        if($wpdb->last_error !== '') { 

            $_SESSION['add_error_message_session'] = $wpdb->last_error;
            $redirect_url = admin_url().'admin.php?page=school-events&action=add';
            wp_redirect($redirect_url);
            die();

        }else{

            $_SESSION['add_message_session'] = 'Save successfully';
            
        }


    }  


    if ($_POST['mode'] == 'edit') {

        $wpdb->query(
            $wpdb->prepare("UPDATE {$wpdb->prefix}schoolevents
            SET churchschoolname='".$_POST['churchschoolname']."', 
            churchschoolcity='".$_POST['churchschoolcity']."',
            state= '".$_POST['state']."',
            name = '".$_POST['name']."',
            email= '".$_POST['email']."',
            phone= '".$_POST['phone']."',
            eventname= '".$_POST['eventname']."',
            eventstart= '".$_POST['eventstart']."',
            eventend= '".$_POST['eventend']."',
            onlinelink= '".$_POST['onlinelink']."',
            message= '".$_POST['message']."'
              WHERE id='15'")
        );


        $lastid = $_POST['customer'];

        if($wpdb->last_error !== '') { 

            $_SESSION['add_error_message_session'] = "====".$wpdb->last_error;

            $redirect_url = admin_url().'admin.php?page=school-events&action=edit&customer='.$lastid;
            wp_redirect($redirect_url);
            die();

        }else{

           $_SESSION['edit_message_session'] = 'Updated successfully';
            
        }

    }

    $delete_nonce = wp_create_nonce( 'sp_delete_customer' );
    
    $redirect_url = admin_url().'admin.php?page=school-events&action=edit&customer='.$lastid;
    wp_redirect($redirect_url);
    die();
}

function school_events_admin_notice__success() {

  $screen = get_current_screen();

  //if ( $screen->id !== 'toplevel_page_school-events') return;

    if (isset($_SESSION["add_message_session"])) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( $_SESSION['add_message_session'], 'school-events-funds' ); ?></p>
        </div>
        <?php
        if (basename($_SERVER['PHP_SELF']) != $_SESSION["add_message_session"]) {
            unset($_SESSION['add_message_session']);
        }
    }


    if (isset($_SESSION["edit_message_session"])) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( $_SESSION['edit_message_session'], 'school-events-funds' ); ?></p>
        </div>
        <?php
        if (basename($_SERVER['PHP_SELF']) != $_SESSION["edit_message_session"]) {
            unset($_SESSION['edit_message_session']);
        }
    }

    if (isset($_SESSION["add_error_message_session"])) {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e( $_SESSION['add_error_message_session'], 'school-events-funds' ); ?></p>
        </div>
        <?php
        if (basename($_SERVER['PHP_SELF']) != $_SESSION["add_error_message_session"]) {
            unset($_SESSION['add_error_message_session']);
        }
    }

}
add_action( 'admin_notices', 'school_events_admin_notice__success' );



