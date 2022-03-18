<?php  

namespace MangoCube_Packages\Options\Fields;

class Date_Time extends Base_Field {

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
			'sizes'			=> 'regular',
			'readonly'		=> false,
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
	public function render_field($label = false) {

		$class = 'mangocube-datepicker bookatdatetime-local-fld';

		switch ($this->field['sizes']) {
			case "small":
				$class .= ' small-text';
				break;
			case "large":
				$class .= ' large-text';
				break;
			default:
				$class .= ' regular-text';
				break;
		}
		if($label):
			
			echo '<div class="ray-form-field option-date-wrapper mangocube-datetime-local">';
			echo sprintf('<label class="ray-option-label"> %s </label>',$this->field['title']);
		   
		endif; 
	?>
		<input type="datetime-local" class="<?php echo esc_attr($class); ?>" name="<?php echo esc_attr($this->option_name); ?>" id="<?php echo esc_attr($this->option_id); ?>" value="<?php echo esc_attr($this->value); ?>">
		<span class="description"><?php echo $this->field['desc']; ?></span>
		<?php if($label): ?>
		  <?php
		     echo '</div>';
			?>
		<?php endif; ?>	 
	<?php
	}

	public function sanitize( $value ) {
		
		$sanitize_value = strip_tags($value);

		return $sanitize_value;
	}

}


?>