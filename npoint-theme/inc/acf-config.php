<?php 


//ACF OPTIONS
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
        'page_title'    => 'Site settings',
        'menu_title'    => 'Site settings',
        'menu_slug'     => 'site_settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    

    if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_64e47d8f45c40',
            'title' => 'Site Settings',
            'fields' => array(
                array(
                    'key' => 'field_64e47e24ac491',
                    'label' => 'Store image',
                    'name' => 'store_image',
                    'aria-label' => '',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                    'preview_size' => 'medium',
                ),
                array(
                    'key' => 'field_64e47d8f8063f',
                    'label' => 'Store info',
                    'name' => 'store_desc',
                    'aria-label' => '',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'full',
                    'media_upload' => 1,
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_64e82a3cd116b',
                    'label' => 'Gifs',
                    'name' => 'redeem_points',
                    'aria-label' => '',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'pagination' => 0,
                    'min' => 0,
                    'max' => 0,
                    'collapsed' => '',
                    'button_label' => 'Add Row',
                    'rows_per_page' => 20,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_64e82d77d116f',
                            'label' => 'Image',
                            'name' => 'image',
                            'aria-label' => '',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'url',
                            'library' => '',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                            'preview_size' => 'medium',
                            'parent_repeater' => 'field_64e82a3cd116b',
                        ),
                        array(
                            'key' => 'field_64e82a8bd116c',
                            'label' => 'Title',
                            'name' => 'title',
                            'aria-label' => '',
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
                            'maxlength' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'parent_repeater' => 'field_64e82a3cd116b',
                        ),
                        array(
                            'key' => 'field_64e82ce8d116d',
                            'label' => 'Description',
                            'name' => 'description',
                            'aria-label' => '',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'maxlength' => '',
                            'rows' => '',
                            'placeholder' => '',
                            'new_lines' => '',
                            'parent_repeater' => 'field_64e82a3cd116b',
                        ),
                        array(
                            'key' => 'field_64e82cf3d116e',
                            'label' => 'Type',
                            'name' => 'type',
                            'aria-label' => '',
                            'type' => 'radio',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array(
                                'NFT Card' => 'NFT Card',
                                'Token NEAR' => 'Token NEAR',
                            ),
                            'default_value' => 'NFT Card',
                            'return_format' => 'value',
                            'allow_null' => 0,
                            'other_choice' => 0,
                            'layout' => 'vertical',
                            'save_other_choice' => 0,
                            'parent_repeater' => 'field_64e82a3cd116b',
                        ),
                        array(
                            'key' => 'field_64e82da1d1170',
                            'label' => 'redeem rate (points)',
                            'name' => 'price',
                            'aria-label' => '',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 1,
                            'min' => '',
                            'max' => '',
                            'placeholder' => 'how many points needed to redeem?',
                            'step' => '',
                            'prepend' => '',
                            'append' => '',
                            'parent_repeater' => 'field_64e82a3cd116b',
                        ),
                        array(
                            'key' => 'field_64e82e9bd1171',
                            'label' => 'NEAR token',
                            'name' => 'near_token',
                            'aria-label' => '',
                            'type' => 'number',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_64e82cf3d116e',
                                        'operator' => '==',
                                        'value' => 'Token NEAR',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '0.1',
                            'min' => '0.1',
                            'max' => 1,
                            'placeholder' => '',
                            'step' => '',
                            'prepend' => '',
                            'append' => '',
                            'parent_repeater' => 'field_64e82a3cd116b',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'site_settings',
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
            'show_in_rest' => 0,
        ));
        
        endif;		
        
}
//END ACF options