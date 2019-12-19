<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
'key' => 'group_5dd3f6953c32a',
'title' => 'Real estate Field Group',
'fields' => array(
array(
'key' => 'field_5dd3f6c8df323',
'label' => 'Gallery',
'name' => 'gallery',
'type' => 'gallery',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
'width' => '',
'class' => '',
'id' => '',
),
'min' => '',
'max' => '',
'insert' => 'append',
'library' => 'all',
'min_width' => '',
'min_height' => '',
'min_size' => '',
'max_width' => '',
'max_height' => '',
'max_size' => '',
'mime_types' => '',
),
array(
'key' => 'field_5dd3f6e1df324',
'label' => 'Slides',
'name' => 'slides',
'type' => 'repeater',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
'width' => '',
'class' => '',
'id' => '',
),
'collapsed' => '',
'min' => 0,
'max' => 0,
'layout' => 'table',
'button_label' => '',
'sub_fields' => array(
array(
'key' => 'field_5dd3f6fadf325',
'label' => 'text',
'name' => 'text',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
'width' => '',
'class' => '',
'id' => '',
),
'default_value' => '',
'placeholder' => '',
'prepend' => '',
'append' => '',
'maxlength' => '',
),
),
),
array(
'key' => 'field_5dd3f78c11c70',
'label' => 'Subtitle',
'name' => 'subtitle',
'type' => 'text',
'instructions' => '',
'required' => 0,
'conditional_logic' => 0,
'wrapper' => array(
'width' => '',
'class' => '',
'id' => '',
),
'default_value' => '',
'placeholder' => '',
'prepend' => '',
'append' => '',
'maxlength' => '',
),
),
'location' => array(
array(
array(
'param' => 'post_type',
'operator' => '==',
'value' => 'real_estates',
),
),
),
'menu_order' => 0,
'position' => 'normal',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

endif;