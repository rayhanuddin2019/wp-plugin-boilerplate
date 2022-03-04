<?php  

namespace MangoCube_Packages\Options\Fields;

class Select extends Base_Field {

	/**
	 * __construct
	 *
	 * This function will setup the field type data
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct( $field, $value, $parent ) {
		//vars
		$this->parent = $parent;
		$this->option_name = $field['option_name'];
		$this->option_id   = parent::beautifyid($field['option_name']);

		$this->value = $value;
		$this->field = wp_parse_args( $field, array(
			'id'			=> '',
			'title'			=> '',
			'desc'			=> '',
			'default' 		=> '',
			'holder'		=> __('Select', 'mangocube'),
			'sizes'			=> 'regular',
			'readonly'		=> false,
			'options'		=> null
		) );

		// If value does not set, use the default
		if( is_null($this->value) ) {
			$this->value = $this->field['default'];
		}

		parent::__construct($this->field);
	}

	/**
	 * Render field
	 *
	 * Create the HTML interface for your field
	 *
	 * @param $field - an array holding all the field's data
	 *
	 * @since 1.0
	 * @return void
	 */
	public function render_field() {
		
		$options = (array) $this->field['options'];

		$class = '';
		switch ($this->field['sizes']) {
			case "small":
				$class .= ' smangocube-small-select';
				break;
			case "large":
				$class .= ' mangocube-large-select';
				break;
			default:
				$class .= ' mangocube-regular-select';
				break;
		}
	?>
		<select class="<?php echo esc_attr($class); ?>" name="<?php echo esc_attr($this->option_name); ?>" id="<?php echo esc_attr($this->option_id); ?>">
		<?php  
			// Placeholder
			if( empty($this->value) && !empty($options) ) {
				echo '<option value="" disabled selected>'. esc_html( $this->field['holder'] ) .'</option>';
			} elseif ( empty($options) ) {
				echo '<option value="" disabled selected>'. __('Nothing found.', 'mangocube') .'</option>';
			}

			foreach ($options as $val => $label) {
				printf('<option value="%1$s" %2$s>%3$s</option>',
					esc_attr( $val ),
					selected($val, $this->value, false ),
					esc_html( $label )
				);
			}
		?>
		</select>
		<span class="description"><?php echo $this->field['desc']; ?></span>
	<?php
	}

	public function sanitize( $input ) {

		$sanitize_input = $input;

		return $sanitize_input;
	}

}



?>