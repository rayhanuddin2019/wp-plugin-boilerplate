<?php  

namespace MangoCube_Packages\Options\Fields;

class Views {

	// Hold it's parent object which
	var $parent = null;

	/**
	 * Fire!
	 *
	 * @since 1.0.0
	 */
	public function __construct( $parent ) {
		$this->parent = $parent;
	}

	/**
	 * Create the HTML interface for admin options page
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_options_page() {

		$section_ids = array_keys($this->parent->sections);
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $section_ids[0];
		$base_url = menu_page_url( $this->parent->configs['page_slug'], false );	

		ob_start();
		?>
		<div class="wrap">
			<h2 class="nav-tab-wrapper">
				<?php  
					foreach ( $this->parent->sections as $section ) {
						$actived = ($active_tab == $section['id']) ? 'nav-tab-active' : '';
						if( isset($section['type']) && $section['type'] == 'url' ) {
							printf('<a href="%1$s" title="%2$s" class="nav-tab %3$s">%4$s</a>',
								$section['url'],
								$section['title'],
								$actived,
								$section['title']
							);
						} else {
							printf('<a href="%1$s" title="%2$s" class="nav-tab %3$s">%4$s</a>',
								add_query_arg('tab', $section['id'], $base_url),
								$section['title'],
								$actived,
								$section['title']
							);
						}
					}
				?>
			</h2>
			<!-- END .nav-tab-wrapper -->
			<div id="tab_container">
			<?php  
				if( isset($this->parent->sections[$active_tab]['type']) && 'blank' == $this->parent->sections[$active_tab]['type']) {
					do_action( 'mangocube_options_page_' . $this->parent->configs['opt_name'] .'_'. $this->parent->sections[$active_tab]['id']);
				} else {
			?>
				<form action="options.php" method="post">
					<table class="form-table mangocube-form-table">
					<?php  
						settings_fields( $this->parent->configs['opt_name'] );
						do_settings_fields( $this->parent->configs['opt_name'] . '_' . $active_tab, $this->parent->configs['opt_name'] . '_' . $active_tab );
					?>	
					</table>
					<!-- END .form-table -->
					<p class="submit">
					<?php $link = add_query_arg(array( 'tab' => $active_tab,'action'=>'reset', 'reset_nonce' => wp_create_nonce('mangocube_reset')), $base_url); ?>
						<a href="<?php echo $link; ?>" class="button button-secondary"><?php _e('Reset', 'mangocube'); ?></a>
					<?php 
						submit_button( __('Save Changes', 'mangocube'), 'primary', 'save', false ); 
					?>
					</p>
				</form>
			<?php } ?>
			</div>
			<!-- END #tab_container -->
		</div>
		<!-- END .wrap -->
	<?php
		$outup = ob_get_contents();
		ob_end_clean();

		echo $outup;
	}
	
}


?>