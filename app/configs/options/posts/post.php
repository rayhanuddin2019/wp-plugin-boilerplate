<?php

return array(

    'title'      => 'Mangocube Extra Items',
    'metabox_id' => 'bookat_extra_items',   //unique
    'post_type'  => 'postsssssss',
    'priority'   => 'high', // low, high
    'position'   => 'normal',         // 
    'fields'     => array(
        'bookat_extra_items' => array(
            'title' => 'Add Extra Items',
            'type' => 'repeat',
            'style' => 'small',
            'sub_fields' => array(
                'name' => array(
                    'title' => 'Name',
                    'type' => 'text',
                    'holder' => 'Item Name',
                    'default' => 'Item Name'
                ),
                'price' => array(
                    'title' => 'Price',
                    'type' => 'number',
                    'default' => 5
                ),
                'enable_quantity' => array(
                    'title' => 'Enable Quantity',
                    'type' => 'checkbox',
                    'default' => 1
                ),
                'quantity_unit' => array(
                    'title' => 'Quantity Unit',
                    'type' => 'text',
                    'holder' => 'e.g grams',
                    'default' => 'grams'
                ),
            )
        ),
    ),
);
