<?php

     $sections = []; 
     //General Section
     $sections['general'] = array(
        'title' 	=> 'General',
        'id'		=> 'general',
        'priority'	=> 1,
        'fields'	=> array(
            'mangocube_input_heading' => array(
                'id' => 'mangocube_input_heading',
                'type' => 'heading',
                'title' => 'Input',
                'desc' => 'you can set different sizes for input field type.'
            ),
            'mangocube_small_text' => array(
                'type'	=> 'text',
                'title'	=> 'Small Text',
                'desc'	=> '',
                'default' 	=> '',
                'sizes'	=> 'small'
            ),
            'mangocube_regular_text' => array(
                'type'	=> 'text',
                'title'	=> 'Regular Text',
                'desc'	=> '',
                'default' 	=> '',
                'sizes'	=> 'regular'
            ),
            'mangocube_large' => array(
                'type'	=> 'text',
                'title'	=> 'Large Text',
                'desc'	=> '',
                'default' 	=> '',
                'sizes'	=> 'large'
            ),
            'mangocube_number' => array(
                'type'	=> 'number',
                'title'	=> 'Number',
                'desc'	=> 'default value is 150.',
                'default' 	=> '150',
                'sizes'	=> 'regular'
            ),
            'mangocube_email' => array(
                'type'	=> 'email',
                'title'	=> 'Email',
                'desc'	=> '',
                'default' 	=> '',
                'sizes'	=> 'regular'
            ),
            'date_date' => array(
                'type'	=> 'date',
                'title'	=> 'Date',
                'desc'	=> '',
                'sizes'	=> 'regular'
            ),
            'select' => array(
                'title' => 'Select',
                'type' => 'select',
                'holder' => 'Select your country',
                'options' => array(
                    'china' => 'China',
                    'usa'	=> 'America',
                    'germany' => 'Germany'
                )
            ),
            'mangocube_checkboxradio_heading' => array(
                'id' => 'mangocube_checkboxradio_heading',
                'type' => 'heading',
                'title' => 'Chekbox/Radio',
                'desc' => 'you can set different style for checkbox/radio field type.'
            ),
            'mangocube_checkbox' => array(
                'title' => 'CheckBox',
                'desc'	=> '',
                'type' => 'checkbox',
                'default' => '1' //1 = on | 0 = off
            ),
            'mangocube_multi_checkbox' => array(
                'title'	=> 'Multi Checkbox 1',
                'desc'	=> 'Multi Checkbox style 1',
                'type'	=> 'checkbox',
                'style'		=> 1,
                'options'	=> array(
                    'girl'	=> 'Are you girl?',
                    'under_25' => 'Are you under 25?',
                    'venus'		=> 'You are my venus!'
                ),
                'default' => array(
                    'girl' => '1',
                    'venus'	=> '1'
                )
            ),
            'mangocube_multi_checkbox2' => array(
                'title'	=> 'Multi Checkbox 2',
                'desc'	=> 'Multi Checkbox style 2',
                'type'	=> 'checkbox',
                'style'		=> 2,
                'options'	=> array(
                    'girl'	=> 'Are you girl?',
                    'under_25' => 'Are you under 25?',
                    'venus'		=> 'You are my venus!'
                ),
                'default' => array(
                    'girl' => '1',
                    'venus'	=> '1'
                )
            ),
            'mangocube_radio' => array(
                'title'	=> 'Radio 1',
                'desc'	=> 'Radio style 1',
                'type'	=> 'radio',
                'style'		=> 1,
                'options'	=> array(
                    'blue'	=> 'Blue',
                    'red' => 'Red',
                    'green' => 'Green'
                ),
                'default' => 'red'
            ),
            'mangocube_radio_2' => array(
                'title'	=> 'Radio 2',
                'desc'	=> 'Radio style 2',
                'type'	=> 'radio',
                'style'		=> 2,
                'options'	=> array(
                    'blue'	=> 'Blue',
                    'red' => 'Red',
                    'green' => 'Green'
                ),
                'default' => 'red'
            ),
            'mangocube_editor_heading' => array(
                'id'	=> 'mangocube_editor_heading',
                'type'	=> 'heading',
                'title'	=> 'More'
            ),
            'mangocube_html' => array(
                'id'	=> 'mangocube_html',
                'type'	=> 'html',
                'title'	=> 'HTML',
                'content' => '<div style="width:99%; padding: 5px;" class="updated below-h2">Start to code!</div>'
            ),
            'mangocube_textarea' => array(
                'id'	=> 'mangocube_textarea',
                'type'	=> 'textarea',
                'sizes'	=> 'large',
                'title'	=> 'Textarea',
                'desc'	=> 'this is the description.'
            ),
            'mangocube_richEditor' => array(
                'id' => 'mangocube_richEditor',
                'type' => 'rich_editor',
                'title' => 'Rich Editor',
                'default' => 'Hello, World!',
                'sizes' => 15
            ),
            
        )
    );

    //Advanced
    $sections['advanced'] = array(
        'title' 	=> 'Advanced',
        'id'		=> 'advanced',
        'priority'	=> 11,
        'fields'	=> array(
            'mangocube_color' => array(
                'type' => 'color',
                'title' => 'Color',
                'desc'	=> '',
                'default' => '#dd3333'
            ),
           
            'layout' => array(
                'title'	=> 'Image Select',
                'desc'  => '',
                'type'	=> 'image_select',
                'options' => array(
                    'left_sidebar' => array(
                        'label'	=> 'Left Sidebar',
                        'img_url'	=> 'http://fakeimg.pl/100x100/?text=Left'
                    ),
                    'right_sidebar' => array(
                        'label'	=> 'Right Sidebar',
                        'img_url'	=> 'http://fakeimg.pl/100x100/?text=Right'
                    )
                ),
                'default' => 'left_sidebar'
            ),
            'mangocube_repeatHeading' => array(
                'type'	=> 'heading',
                'title' => 'Repeat'
            ),
            'mangocube_repeat' => array(
                'title' => 'Repeat',
                'type' => 'repeat',
                'style' => 'large',
                'sub_fields' => array(
                    'name' => array(
                        'title' => 'Name',
                        'type' => 'text',
                        'holder' => 'Your Name',
                        'default' => 'Jhon'
                    ),
                    'country' => array(
                        'title' => 'Country',
                        'type' => 'select',
                        'options' => array(
                            'china' => 'Russia',
                            'usa'	=> 'Gana',
                            'germany' => 'SA'
                        )
                    ),
                    'sex' => array(
                        'title' => 'Sex',
                        'desc' => '',
                        'type' => 'radio',
                        'options' => array(
                            'boy' => 'Boy',
                            'girl'	=> 'Girl',
                            'alien' => 'Alien'
                        )
                    ),
                    'subscribe' => array(
                        'title' => 'Subscribe',
                        'desc' => 'Subscribe our site.',
                        'type' => 'checkbox',
                        'default' => '1'
                    )
                )
            )
        )
    );

    //Url
    $sections['url'] = array(
        'title'	=> 'Url',
        'id'	=> 'url',
        'priority'	=> 26,
        'type'	=> 'url',
        'url'	=> 'quomodosoft.com'
    );
  

 return $sections;   
