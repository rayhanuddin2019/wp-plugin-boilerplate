<?php

    /**
     * Resize any image from
     *
     * @param url  $url image 
     * @param mix $width image width size false for auto
     * @param mix $height image height size false for auto
     * @param boolen  $crop 
     * @return url string path
     * @version 1.0 very beginning
     * 
     */ 

    if ( ! function_exists( 'mangocube_resize' ) ) {
        function mangocube_resize( $url, $width = false, $height = false, $crop = false ) {

            $mangocube_resize = \Mangocube\helpers\resize::getInstance();
            $response  = $mangocube_resize->process( $url, $width, $height, $crop );

            return ( ! is_wp_error( $response ) && ! empty( $response['src'] ) ) ? $response['src'] : $url;
        }
    }

	/**
	 * Get the edited post ID (early) when loading the Edit Post screen.
	 */
	function mangocube_get_edited_post_id() {
		
		if (
			! empty( $_GET['post'] ) &&
			! empty( $_GET['action'] ) &&
			$_GET['action'] === 'edit' &&
			! empty( $GLOBALS['pagenow'] ) &&
			$GLOBALS['pagenow'] === 'post.php'
		) {
			return (int) $_GET['post']; // post_ID
		}

		return 0;
	}

	/**
	 * @return bool
	 * @param domain
	 */

	if( !function_exists( 'mangocube_is_valid_domain_name' ) ){

		function mangocube_is_valid_domain_name( $domain_name ) {
			return ( preg_match( "/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name ) // valid chars check
					&& preg_match( "/^.{1,253}$/", $domain_name ) // overall length check
					&& preg_match( "/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name ) ); // length of each label
		}

	}

    
    /**
     * Safe load variables from an file
     * Use this function to not include files directly and to not give access to current context variables (like $this)
     *
     * @param string $file_path
     * @param array $_extract_variables Extract these from file array('variable_name' => 'default_value')
     * @param array $_set_variables Set these to be available in file (like variables in view)
     *
     * @return array
     */

    function mangocube_get_variables_from_file( $file_path, array $_extract_variables, array $_set_variables = array() ) {
        extract( $_set_variables, EXTR_REFS );
        unset( $_set_variables );

        require $file_path;

        foreach ( $_extract_variables as $variable_name => $default_value ) {
            if ( isset( $$variable_name ) ) {
                $_extract_variables[ $variable_name ] = $$variable_name;
            }
        }

        return $_extract_variables;
    }

    /**
	 * Safe render a view and return html
	 * In view will be accessible only passed variables
	 * Use this function to not include files directly and to not give access to current context variables (like $this)
	 *
	 * @param string $file_path
	 * @param array $view_variables
	 * @param bool $return In some cases, for memory saving reasons, you can disable the use of output buffering
	 *
	 * @return string HTML
	 */

	function mangocube_render_view( $file_path, $view_variables = array(), $return = true ) {

		if ( ! is_file( $file_path ) ) {
			return '';
		}

		extract( $view_variables, EXTR_REFS );
		unset( $view_variables );

		if ( $return ) {
			ob_start();
			require $file_path;

			return ob_get_clean();
		} else {
			require $file_path;
		}

		return '';
    }
    
     /**
     * Generate html tag
     *
     * @param string $tag Tag name
     * @param array $attr Tag attributes
     * @param bool|string $end Append closing tag. Also accepts body content
     *
     * @return string The tag's html
     */

    function mangocube_html_tag( $tag, $attr = array(), $end = false ) {
        $html = '<' . $tag . ' ' . mangocube_attr_to_html( $attr );

        if ( $end === true ) {
            # <script></script>
            $html .= '></' . $tag . '>';
        } else if ( $end === false ) {
            # <br/>
            $html .= '/>';
        } else {
            # <div>content</div>
            $html .= '>' . $end . '</' . $tag . '>';
        }

        return $html;
    }

    /**
     * Convert to Unix style directory separators
     *  @param string $path url
     */
    function mangocube_fix_path( $path ) {

        $windows_network_path = isset( $_SERVER['windir'] ) && in_array( substr( $path, 0, 2 ),
                array( '//', '\\\\' ),
                true );
        $fixed_path           = untrailingslashit( str_replace( array( '//', '\\' ), array( '/', '/' ), $path ) );

        if ( empty( $fixed_path ) && ! empty( $path ) ) {
            $fixed_path = '/';
        }

        if ( $windows_network_path ) {
            $fixed_path = '//' . ltrim( $fixed_path, '/' );
        }

        return $fixed_path;
    }

    
	/**
	 * Strip slashes from values, and from keys if magic_quotes_gpc = On
	 */
	function mangocube_stripslashes_deep_keys( $value ) {
		static $magic_quotes = null;
		if ( $magic_quotes === null ) {
			$magic_quotes = false; //https://www.php.net/manual/en/function.get-magic-quotes-gpc.php - always returns FALSE as of PHP 5.4.0. false fixes https://github.com/ThemeFuse/Unyson/issues/3915
		}

		if ( is_array( $value ) ) {
			if ( $magic_quotes ) {
				$new_value = array();
				foreach ( $value as $key => $val ) {
					$new_value[ is_string( $key ) ? stripslashes( $key ) : $key ] = mangocube_stripslashes_deep_keys( $val );
				}
				$value = $new_value;
				unset( $new_value );
			} else {
				$value = array_map( 'mangocube_stripslashes_deep_keys', $value );
			}
		} elseif ( is_object( $value ) ) {
			$vars = get_object_vars( $value );
			foreach ( $vars as $key => $data ) {
				$value->{$key} = mangocube_stripslashes_deep_keys( $data );
			}
		} elseif ( is_string( $value ) ) {
			$value = stripslashes( $value );
		}

		return $value;
	}

	/**
	 * Add slashes to values, and to keys if magic_quotes_gpc = On
	 */
	function mangocube_addslashes_deep_keys( $value ) {
		static $magic_quotes = null;
		if ( $magic_quotes === null ) {
			$magic_quotes = get_magic_quotes_gpc();
		}

		if ( is_array( $value ) ) {
			if ( $magic_quotes ) {
				$new_value = array();
				foreach ( $value as $key => $value ) {
					$new_value[ is_string( $key ) ? addslashes( $key ) : $key ] = mangocube_addslashes_deep_keys( $value );
				}
				$value = $new_value;
				unset( $new_value );
			} else {
				$value = array_map( 'mangocube_addslashes_deep_keys', $value );
			}
		} elseif ( is_object( $value ) ) {
			$vars = get_object_vars( $value );
			foreach ( $vars as $key => $data ) {
				$value->{$key} = mangocube_addslashes_deep_keys( $data );
			}
		} elseif ( is_string( $value ) ) {
			$value = addslashes( $value );
		}

		return $value;
	}

	/**
	 * Use this id do not want to enter every time same last two parameters
	 * Info: Cannot use default parameters because in php 5.2 encoding is not UTF-8 by default
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	function mangocube_htmlspecialchars( $string ) {
		return htmlspecialchars( $string, ENT_QUOTES, 'UTF-8' );
	}

	/**
	 * Generate attributes string for html tag
	 *
	 * @param array $attr_array array('href' => '/', 'title' => 'Test')
	 *
	 * @return string 'href="/" title="Test"'
	 */
	function mangocube_attr_to_html( array $attr_array ) {
		$html_attr = '';

		foreach ( $attr_array as $attr_name => $attr_val ) {
			
			if ( $attr_val === false ) {
				continue;
			}

			$html_attr .= $attr_name . '="' . mangocube_htmlspecialchars( $attr_val ) . '" ';
		}

		return $html_attr;
	}

	/**
	 * Download file from remote
	 *
	 * @param string $url 
	 * @since 1.0
	 * @return string $destination path
	 */

	if(!function_exists('mangocube_download_file')){
		
		function mangocube_download_file($url, $destination) {
			echo 'downloading ' . $destination . "\n";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt( $ch, CURLOPT_ENCODING, "UTF-8" );
		
			$data = curl_exec ($ch);
			$error = curl_error($ch);
		
			curl_close ($ch);
		
			$file = fopen($destination, "w+");
			fputs($file, $data);
			fclose($file);
		}
	}

	/**
	 * Fetches post types. Based on helper functions developed inhouse.
	 *
	 * @since 1.0
	 *
	 * @param boolean $public - Queries the get_post_types to fetch publicly-available post types.
	 * @param string $value - Fetches post types that are builtin, custom, or both. Values can be 'builtin', 'custom', or the default value, 'all'.
	 */
	function mangocube_get_post_types( $public = true, $value = 'all' ) {

		// Fetch builtin post types.
		$args_builtin = array(
			'public' => $public,
			'_builtin' => true,
		);

		$post_types_builtin = get_post_types( $args_builtin, 'objects' );

		// Fetch custom post types.
		$args_custom = array(
			'public' => $public,
			'_builtin' => false,
		);

		$post_types_custom = get_post_types( $args_custom, 'objects' );

		// Converge or pick post types based on selection.
		switch ( $value ) {
			case 'builtin' :
				$post_types = $post_types_builtin;
			break;

			case 'custom' :
				$post_types = $post_types_custom;
			break;

			default :
				$post_types = array_merge( $post_types_builtin, $post_types_custom );
			break;
		}

		return $post_types;
	}

	/**
	 * Service Container
	 * @since 1.0
	 * @return container object
	 */

	if( !function_exists('mangocube_app') ){

		function mangocube_app(){

				static $container = null;
				
				if (!$container instanceof \MangoCube_Packages\DI\Container) {
					$container = new MangoCube_Packages\DI\Container();
				}
			
				return $container;
		}
	}

	/**
	 * @return filelist
	 * @since 1.0
	 * @param path
	 * @param extention
	 ****/
	if( !function_exists( 'mangocube_get_dir_file_list' ) ){

		function mangocube_get_dir_file_list($dir = 'dir',$ext = 'php'){
		
			if( ! is_dir($dir) ){
				return [];
			}
			
			$files = [];
			
			foreach (glob("$dir/*.$ext") as $filename) {
				$files[basename( dirname($filename) ) .'-'. basename($filename,'.'.$ext)] = $filename;
			}
		
			return $files;
		
		}
		
	}

	if( !function_exists('mangocube_plugin_activation_link_url') ){

		/*****
		 * @return url
		 * @since 1.0
		 * @param plugin file name
		 * 
		 */
		function mangocube_plugin_activation_link_url( $plugin='woocommerce/woocommerce.php' )
		{
			$activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
			// change the plugin request to the plugin to pass the nonce check
			$_REQUEST['plugin'] = $plugin;
			$activateUrl = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin);
	
			return $activateUrl;
		}

	}
   
	





