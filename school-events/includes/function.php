<?php

defined( 'ABSPATH' ) || exit;

//schoolevents
//class SchoolEvents
//form school_events
//slug school-events
//tb schoolevents


//School_Events

require_once 'SchoolEvents.php';
require_once 'school_events.php';


function School_Events_register_session() {

    if (!session_id())
        session_start();
}

add_action('init', 'School_Events_register_session');


add_action('admin_enqueue_scripts', 'School_Events_admin_enqueue_scripts', 10, 1);

function School_Events_admin_enqueue_scripts(){ 

  wp_enqueue_style('School_Events_admin_style', School_Events_URL.'assets/css/School_Events_admin.css', array(), '1.0', 'all');

  wp_register_script('School_Events_admin_script', School_Events_URL.'assets/js/School_Events_admin.js', array('jquery'), '1.0', true);
  wp_enqueue_script( 'School_Events_admin_script' );

  wp_enqueue_style('School_Events_admin_validation_style', School_Events_URL.'assets/css/screen.css', array(), '1.0', 'all');

  wp_enqueue_script('School_Events_admin_validation_script', School_Events_URL.'assets/js/jquery.validate.min.js', array('jquery'), '1.0', true);
  
  wp_enqueue_script( 'common' );
  wp_enqueue_script( 'wp-lists' );
  wp_enqueue_script( 'postbox' );

  wp_enqueue_script('select2-admin-js', School_Events_URL.'assets/js/select2.js', array('jquery'), '1.0', true);
  wp_enqueue_style('select2-admin-css', School_Events_URL.'assets/css/select2.css', array(), '1.0', 'all');

  wp_enqueue_script( 'jquery-ui-datepicker' );

  wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );

  wp_enqueue_script('chart-admin-js', School_Events_URL.'assets/chart/Chart.js', array('jquery'), '1.0', false);
  wp_enqueue_script('chart-utils-admin-js', School_Events_URL.'assets/chart/utils.js', array('jquery'), '1.0', false);

}


/*
* Get wp_list_table functions 
*/
function get_filter_by_colum_name($colums = array(), $tb_name){ 
  global $wpdb;
  unset($colums['cb']);
  ?>
  <!---->
  <div class="alignleft actions bulkactions">
  <?php foreach ($colums as $key => $value) { ?>


    <?php if ($key == 'member_id') { ?>

      <!---->
      <?php 
      $data = $wpdb->get_results("select DISTINCT ".$key." from {$wpdb->prefix}".$tb_name." ORDER BY ".$key." DESC", ARRAY_A);

      $count = count($data);
      ?>

      <?php if( $data ){ ?>

        <select name="<?php echo $key;?>_filter" id="<?php echo $key;?>_filter">
            <option value="">Filter by <?php echo $value;?></option>
            <?php foreach( $data as $customer ){ 
                $selected = '';
                if( $_REQUEST[$key.'_filter'] == $customer[$key] ){ 
                    $selected = ' selected = "selected"';   
                }

                $name = get_member_name_by_id($customer[$key]);
                ?>
                <option value="<?php echo $customer[$key]; ?>" <?php echo $selected;?> ><?php echo $name; ?></option>
            <?php } ?>
        </select>

        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#<?php echo $key;?>_filter').select2({placeholder : "<?php echo $value;?>" });
            });
        </script>

      <?php } ?> 
      <!---->

     
    <?php }else{ ?>

      <!---->
      <?php 
      $data = $wpdb->get_results("select DISTINCT ".$key." from {$wpdb->prefix}".$tb_name." ORDER BY ".$key." DESC", ARRAY_A);

      $count = count($data);
      ?>

      <?php if( $data ){ ?>

        <select name="<?php echo $key;?>_filter" id="<?php echo $key;?>_filter">
            <option value="">Filter by <?php echo $value;?></option>
            <?php foreach( $data as $customer ){ 
                $selected = '';
                if( $_REQUEST[$key.'_filter'] == $customer[$key] ){ 
                    $selected = ' selected = "selected"';   
                }
                ?>
                <option value="<?php echo $customer[$key]; ?>" <?php echo $selected;?> ><?php echo $customer[$key]; ?></option>
            <?php } ?>
        </select>

        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#<?php echo $key;?>_filter').select2({placeholder : "<?php echo $value;?>" });
            });
        </script>

      <?php } ?> 
      <!---->


    <?php } ?>

    

  <?php } ?>



<?php  if ($count != 0) { ?>
<input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">
<?php } ?>


</div>
<!---->
<?php
}


function get_filter_by_colum_name_sql($colums = array()){

  unset($colums['cb']); 

  foreach ($colums as $key => $value) {

    //member_id_filter
    $member_id_filter = ( isset($_REQUEST[$key.'_filter']) ? $_REQUEST[$key.'_filter'] : '');
    if($member_id_filter != '') {
        $sql .= " WHERE ".$key." LIKE '" .$member_id_filter. "'";
    } else  {
        $sql .= '';
    } 

  }

  return $sql;
}
/*
* Get wp_list_table functions 
*/


/*
* Admin popup
*/
add_action('admin_footer', 'tmm_desred_admin_footer');
function tmm_desred_admin_footer(){
?>
<!---->
<?php     
wp_enqueue_style('thickbox');
wp_enqueue_script('thickbox');  
$screen = get_current_screen();
?>
<div>
    <div id="modal-window-id" style="display:none;"> 
    <input type="hidden" name="get_edit_url" id="get_edit_url" value="<?php echo $screen->id;?>"> 
     <a href="#" id="edit_url">Edit</a>
        <div class="control-box ds_model">
            <fieldset>
            <table class="form-table">
            <tbody id="tb_data_ppp">
            </tbody>
            </table>
            </fieldset>
        </div>
    </div>
</div>
<!---->

<script type="text/javascript">
jQuery(document).ready(function($){
    
    jQuery(document).on('click', '.view_data', function(e){ 

      e.preventDefault();

      var target = jQuery(this);

      var ID = target.attr('data-ID');

      var tbn = target.attr('data-tbn');

      var sourse_type = target.attr('data-sourse-type');

      var get_edit_url = jQuery('#get_edit_url').val();

      //
      jQuery.ajax({
        url: '<?php echo admin_url( 'admin-ajax.php');?>',
        type: "POST",
        data: {'action': 'tmm_desred_view_data_action', 'ID': ID, 'tbn': tbn, 'sourse_type': sourse_type, 'get_edit_url': get_edit_url},
        cache: false,
        dataType: 'json',
        beforeSend: function(){
          target.text('loading..');
        },
        complete: function(){
          target.text('View');
        },
        success: function (response) { console.log(response);

          jQuery('#edit_url').attr('href', response['edit_url']);
          jQuery('#tb_data_ppp').html(response['response']);
          tb_show("", "TB_inline?width=600&height=550&inlineId=modal-window-id");

        }
      });
      //

    });
});
</script>
<?php
}

add_action( 'wp_ajax_tmm_desred_view_data_action', 'tmm_desred_view_data_action_fun');
add_action( 'wp_ajax_nopriv_tmm_desred_view_data_action', 'tmm_desred_view_data_action_fun');
function tmm_desred_view_data_action_fun(){

    global $wpdb;

    $ID = $_POST['ID'];

    $tbn = $_POST['tbn']; 

    $sourse_type = $_POST['sourse_type']; 

    $get_edit_url = $_POST['get_edit_url'];
    $page = str_replace("desred_page_","",$get_edit_url);
    $sp_nonce_customer = wp_create_nonce( 'sp_nonce_customer' );
    $edit_url = admin_url()."admin.php?page=".$page."&action=edit&customer=".$ID."&_wpnonce".$sp_nonce_customer;

    $htm = "";

    if (!empty($sourse_type)) {
      
      $thumbnail_id = tmm_desred_get_image($ID, $sourse_type);
      if (!empty($thumbnail_id)) {
          $image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
          $url = $image[0];
      }else{
          $url = School_Events_URL.'assets/image/person-placeholder.png';
      }

      $htm .='<tr>
                <th scope="row">
                  <label for="UserName">Image</label>
                </th>
                <td>
                   <img src="'.$url.'"  style="max-width:100px;">
                </td>
              </tr>';

    }


    $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}".$tbn." WHERE ID=".$ID);

    foreach ($result as $data) {
        
        foreach ($data as $key => $value) {

          $column_name = ucwords(str_replace("_"," ",$key));

          if ($key == 'member_id') {

             $htm .='<tr>
              <th scope="row">
                <label for="UserName">'.$column_name.'</label>
              </th>
              <td>
                 <label for="UserName">'.$value.'</label>
              </td>
            </tr>';


            $htm .='<tr>
              <th scope="row">
                <label for="UserName">Member Name</label>
              </th>
              <td>
                 <label for="UserName">'.get_member_name_by_id($value).'</label>
              </td>
            </tr>';

          }else{

             $htm .='<tr>
              <th scope="row">
                <label for="UserName">'.$column_name.'</label>
              </th>
              <td>
                 <label for="UserName">'.$value.'</label>
              </td>
            </tr>';

          }
            
            
        }

    }

    $myArr = array(
        'response' => $htm,
        'result' => $result,
        'ID' => $ID,
        'tbn' => $tbn,
        'edit_url' => $edit_url,
        'sourse_type' => $sourse_type
    );
    $myJSON = json_encode($myArr); 
    echo $myJSON;
    die();
}

/*
* Admin popup
*/


add_action( 'admin_post_School_EventsExportData', 'School_EventsExportData_fun' );
add_action( 'admin_post_nopriv_School_EventsExportData', 'School_EventsExportData_fun' );
function School_EventsExportData_fun(){

    if ( ! current_user_can( 'manage_options' ) )
        return;

        global $wpdb;

        $tb_name = $_GET['tb_name'];

        $q = "SELECT * FROM {$wpdb->prefix}".$tb_name;

        $get_tb_column = $wpdb->get_results($q, ARRAY_A);

        $header_row = array_keys($get_tb_column[0]);

        $data_rows = $wpdb->get_results($q, ARRAY_N);

        $filename = $tb_name.'.csv';
            
        $fh = @fopen( 'php://output', 'w' );
        fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Content-Description: File Transfer' );
        header( 'Content-type: text/csv' );
        header( "Content-Disposition: attachment; filename={$filename}" );
        header( 'Expires: 0' );
        header( 'Pragma: public' );
        fputcsv( $fh, $header_row );
        foreach ( $data_rows as $data_row ) {
            fputcsv( $fh, $data_row );
        }
        fclose( $fh );
        die();

}