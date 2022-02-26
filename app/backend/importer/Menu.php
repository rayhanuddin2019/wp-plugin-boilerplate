<?php 
namespace Mangocube\backend\importer;

Class Menu implements Iimporter{

  public $nonce = 'mangocube-menu-api-import';
  public $msg_id = 'auto-message';
  public $username = '';
  public $password = '';

  public function get_type(){
      
      return 'mangocube_menu';
  }

  public function register(){

     // Load Importer API
     require_once ABSPATH . 'wp-admin/includes/import.php';
    
    if ( !class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) )
          require_once $class_wp_importer;
    }
     // Register the custom importer.
		if ( defined( 'WP_LOAD_IMPORTERS' ) ) {

			register_importer($this->get_type(), __( 'Nav Menu', 'mangocube' ), __( 'Import <strong>nav menu</strong> and other menu item meta skipped by the default importer', 'mangocube' ), array( $this, 'dispatch' ) );

    }
    
   
  }


  function _import_ajax_handler(){
    
    check_ajax_referer( $this->nonce );
    if ( !current_user_can( 'publish_posts' ) )
      die('-1');
    if ( empty( $_POST['step'] ) )
      die( '-1' );
    define('WP_IMPORTING', true);
    $result = $this->{ 'step' . ( (int) $_POST['step'] ) }();
    if ( is_wp_error( $result ) )
      echo $result->get_error_message();
    die;
  }

  public function dispatch(){
        if ( empty( $_REQUEST['step'] ) )
          $step = 0;
        else
          $step = (int) $_REQUEST['step'];

        $this->header();

        switch ( $step ) {
          case -1 :
            $this->cleanup();
            // Intentional no break
          case 0 :
            $this->welcome();
            break;
          case 1 :
          case 2 :
          case 3 :
            check_admin_referer( $this->nonce );
            $result = $this->{ 'step' . $step }();
            if ( is_wp_error( $result ) ) {
              $this->throw_error( $result, $step );
            }
            break;
        }

        $this->footer();
  }

  function header() {
		echo '<div class="wrap mangocube-menu-importer">';
		
		echo '<h2>' . esc_html__( 'Import Menu' , 'mangocube') . '</h2>';
	}

	function footer() {
		echo '</div>';
	}

	function welcome() {
     
    $current_url = $_SERVER['PHP_SELF'];

    $current_url = add_query_arg( array(
                  'import' => $this->get_type(),
                  'step' => 1,
                  '_wpnonce' =>  wp_create_nonce( $this->nonce ),
                  '_wp_http_referer' =>  esc_attr($_SERVER['REQUEST_URI']),
              ), $current_url );

      $action_url = add_query_arg( array(
                'import' => $this->get_type(),
              ), 'admin.php' );

		?>
      <div class="narrow">
          <form action="<?php echo esc_url($action_url); ?>" method="post">
              <?php wp_nonce_field( $this->nonce ) ?>
              <?php if ( get_option( 'mangocube_remote_username' ) && get_option( 'mangocube_remote_password' ) ) : ?>

                <input type="hidden" name="step" value="<?php echo esc_attr( get_option( 'mangocube_remote_step' ) ) ?>" />
                <p><?php esc_html__( 'It looks like you attempted to import your remote data previously and got interrupted.' , 'mangocube') ?></p>
                <p class="submit">
                  <input type="submit" class="button" value="<?php esc_attr_e( 'Continue previous import' , 'mangocube') ?>" />
                </p>
                <p class="submitbox"><a href="<?php echo esc_url($current_url); ?>" class="deletion submitdelete"><?php _e( 'Cancel &amp; start a new import' , 'mangocube') ?></a></p>
                <p>

              <?php else : ?>

                <input type="hidden" name="step" value="1" />
                <input type="hidden" name="login" value="true" />
                <p><?php _e( 'Howdy! This importer allows you to connect directly to remote Server and download all your entries ' , 'mangocube') ?></p>
                <p><?php _e( 'Enter your LiveJournal username and password below so we can connect to your account:' , 'mangocube') ?></p>

                <table class="form-table">
                  <tr>
                    <th scope="row"><label for="mangocube_remote_username"><?php _e( 'Username' , 'mangocube') ?></label></th>
                    <td><input type="text" name="mangocube_remote_username" id="mangocube_remote_username" class="regular-text" /></td>
                  </tr>

                  <tr>
                    <th scope="row"><label for="mangocube_remote_password"><?php _e( 'Password' , 'mangocube') ?></label></th>
                    <td><input type="password" name="mangocube_remote_password" id="mangocube_remote_password" class="regular-text" /></td>
                  </tr>
                </table>
                <p><?php esc_html__( "<strong>WARNING:</strong> This can take a really long time if you have a lot of entries in your Remote Server, or a lot of comments. Ideally, you should only start this process if you can leave your computer alone while it finishes the import." , 'mangocube') ?></p>
                <p class="submit">
                  <input type="submit" class="button" value="<?php esc_attr_e( 'Connect to Server and Import' , 'mangocube') ?>" />
                </p>

              <?php endif; ?>
          </form>
      </div>
		<?php
  }

	function setup() {
		global $verified;
		// Get details from form or from DB
		if ( !empty( $_POST['mangocube_remote_username'] ) && !empty( $_POST['mangocube_remote_password'] ) ) {
			// Store details for later
			$this->username = $_POST['mangocube_remote_username'];
			$this->password = $_POST['mangocube_remote_password'];
			update_option( 'mangocube_remote_username', $this->username );
			update_option( 'mangocube_remote_password', $this->password );
		
		} else {
			$this->username = get_option( 'mangocube_remote_username' );
			$this->password = get_option( 'mangocube_remote_password' );
		}
    update_option( 'mangocube_menu_last_sync_count', 1 );
		// Set up some options to avoid them autoloading (these ones get big)
		add_option( 'mangocube_menu_sync_item_times',  '', '', 'no' );

		return true;
  }
  
  // Check form inputs and start importing posts
	function step1() {
		global $verified;

		do_action( 'mangocube_menu_import_start' );

		set_time_limit( 0 );
		update_option( 'mangocube_menu_remote_step', 1 );
		
		
		if ( empty( $_POST['login'] ) ) {
			// We're looping -- load some details from DB
			$this->username = get_option( 'mangocube_remote_username' );
			$this->password = get_option( 'mangocube_remote_password' );
	
		} else {
			// First run (non-AJAX)
			$setup = $this->setup();
			if ( !$setup ) {
				return false;
			} else if ( is_wp_error( $setup ) ) {
				$this->throw_error( $setup, 1 );
				return false;
			}
		}

		echo '<div id="mangocube-menu-status">';
		echo '<h3>' . esc_html__( 'Importing Posts' , 'mangocube') . '</h3>';
		echo '<p>' . esc_html__( 'downloading and importing your remote posts...' , 'mangocube') . '</p>';
	
		ob_flush(); flush();

		if ( !get_option( 'mangocube_menu_import_lastsync' ) || '1900-01-01 00:00:00' == get_option( 'mangocube_menu_import_lastsync' ) ) {
			// We haven't downloaded meta yet, so do that first
			$result = $this->download_post_meta();
			if ( is_wp_error( $result ) ) {
				$this->throw_error( $result, 1 );
				return false;
			}
		}
    $action_url = add_query_arg( array(
      'import' => $this->get_type(),
    ), 'admin.php' );


		if ( get_option( 'mangocube_menu_last_sync_count' ) > 0 ) {
     
		?>
			<form action="<?php echo esc_url($action_url); ?>" method="post" id="mangocube-menu-auto-repost">
			  <?php wp_nonce_field( $this->nonce ) ?>
			  <input type="hidden" name="step" id="step" value="1" />
			  <p><input type="submit" class="button" value="<?php esc_attr_e( 'Import the next batch' , 'mangocube') ?>" />
         <span id="<?php echo esc_attr($this->msg_id); ?>"></span></p>
			</form>
			<?php $this->auto_ajax( 'mangocube-menu-auto-repost', $this->msg_id ); ?>
		<?php
		} else {
			echo '<p>' . __( 'Your posts have all been imported, but wait &#8211; there&#8217;s more! Now we need to download &amp; import your comments.' , 'mangocube') . '</p>';
			echo $this->next_step( 2, __( 'Download my comments &raquo;' , 'mangocube') );
			$this->auto_submit();
		}
		echo '</div>';
  }

  function step2(){
      echo '<p>' . __( 'Your comments have all been imported now, but we still need to rebuild your conversation threads.' , 'mangocube') . '</p>';
			echo $this->next_step( 3, __( 'Rebuild my comment threads &raquo;' , 'mangocube') );
			$this->auto_submit();
  }

  function step3(){
    $this->cleanup();
		do_action( 'mangocube_menu_import_done', 'mangocube' );
		$imported_data = 1000;
		echo '<p>' . sprintf( __( "Successfully re-threaded %s steps 3." , 'mangocube'), number_format( $imported_data ) ) . '</p>';
		echo '<h3>';
  }

  function cleanup(){
    
    delete_option( 'mangocube_remote_username' );
		delete_option( 'mangocube_remote_password' );
		delete_option( 'mangocube_menu_import_lastsync' );
    echo '<p>' .  __( "Successfully cleanup database." , 'mangocube'). '</p>';
    return true;
  }

  	// Automatically submit the form with #id to continue the process
	// Hide any submit buttons to avoid people clicking them
	// Display a countdown in the element indicated by $msg for "Continuing in x"
	function auto_ajax( $id = 'mangocube-menu-next-form', $msg = 'auto-message', $seconds = 5 ) {
   
		?><script type="text/javascript">
			next_counter = <?php echo $seconds ?>;
			
			jQuery(document).ready(function(){
				mangocube_menu_msg();
			});

			function mangocube_menu_msg() {
      
				str = '<?php echo esc_js( __( "Continuing in %d&#8230;" , 'mangocube') ); ?>';
				jQuery( '#<?php echo $msg ?>' ).html( str.replace( /%d/, next_counter ) );
				if ( next_counter <= 0 ) {
					if ( jQuery( '#<?php echo $id ?>' ).length ) {
						jQuery( "#<?php echo $id ?> input[type='submit']" ).hide();
						jQuery.ajaxSetup({'timeout':3600000});
						str = '<?php echo esc_js( __( "Processing next step." , 'mangocube') ); ?> <img src="<?php echo esc_url( 'https://loading.io/mod/spinner/clock/sample.gif' ); ?>" alt="" id="processing" align="top" />';
						jQuery( '#<?php echo $msg ?>' ).html( str );
						jQuery('#mangocube-menu-status').load(ajaxurl, {'action':'mangocube_menu_importer',
																'import':'<?php echo esc_attr($this->get_type()); ?>',
																'step':jQuery('#step').val(),
																'_wpnonce':'<?php echo wp_create_nonce( $this->nonce ) ?>',
																'_wp_http_referer':'<?php echo $_SERVER['REQUEST_URI'] ?>'});
						return;
					}
				}
				next_counter = next_counter - 1;
				setTimeout('mangocube_menu_msg()', 1000);
			}
		</script><?php
	}

  // Automatically submit the specified form after $seconds
	// Include a friendly countdown in the element with id=$msg
	function auto_submit( $id = 'mangocube-menu-next-form', $msg = 'auto-message', $seconds = 10 ) {
		?><script type="text/javascript">
			next_counter = <?php echo $seconds ?>;
			jQuery(document).ready(function(){
				mangocube_menu_msg();
			});

			function mangocube_menu_msg() {
				str = '<?php echo esc_js( _e( "Continuing in %d&#8230;" , 'mangocube') ); ?>';
				jQuery( '#<?php echo $msg ?>' ).html( str.replace( /%d/, next_counter ) );
				if ( next_counter <= 0 ) {
					if ( jQuery( '#<?php echo $id ?>' ).length ) {
						jQuery( "#<?php echo $id ?> input[type='submit']" ).hide();
						str = '<?php echo esc_js( __( "Continuing&#8230;" , 'mangocube') ); ?> <img src="<?php echo esc_url( 'https://loading.io/mod/spinner/clock/sample.gif' ); ?>" alt="" id="processing" align="top" />';
						jQuery( '#<?php echo $msg ?>' ).html( str );
						jQuery( '#<?php echo $id ?>' ).submit();
						return;
					}
				}
				next_counter = next_counter - 1;
				setTimeout('mangocube_menu_msg()', 1000);
			}
		</script><?php
	}

  // Returns the HTML for a link to the next page
	function next_step( $next_step, $label, $id = 'mangocube-menu-next-form' ) {
    $action_url = add_query_arg( array(
      'import' => $this->get_type(),
    ), 'admin.php' );

		$str  = '<form action="'. esc_url($action_url) .'" method="post" id="' . $id . '">';
		$str .= wp_nonce_field( $this->nonce, '_wpnonce', true, false );
		$str .= wp_referer_field( false );
		$str .= '<input type="hidden" name="step" id="step" value="' . esc_attr($next_step) . '" />';
    $str .= '<p><input type="submit" class="button" value="' . esc_attr( $label ) . '" />
     <span id="'.$this->msg_id.'"></span></p>';
		$str .= '</form>';

		return $str;
	}

  public function download_post_meta(){
    // $synclist  = [];
    // if ( is_wp_error( $synclist ) )
		// 		return $synclist;
    echo '<p>' . esc_html__( 'Post metadata has been downloaded, proceeding with posts...' , 'mangocube') . '</p>';
  }
  
  function throw_error( $error, $step ) {
		echo '<p><strong>' . $error->get_error_message() . '</strong></p>';
		echo $this->next_step( $step, __( 'Try Again' , 'mangocube') );
	}
}
