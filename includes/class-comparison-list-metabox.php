<?php

class Comparison_List_Metabox
{
    /**
     * Define metabox core
     *
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->register_save_events_meta();
        add_action('save_post_com_comporison_list', function () {
            $this->save_ctp_custom_metadata();
        }, 10, 3);
    }

    public static function get_brands()
    {
        $brands = array(
            'select post' => 'null',
        );
        $args = array('post_type' => 'com_comporison', "showposts" => -1);
        $posts = get_posts($args);

        foreach ($posts as &$value) {
            $brands[$value->post_name] = "".$value->ID;
        }

        return $brands;
    }

    public static function get_list_metaboxes()
    {
        return array(
            array(
                'slug' => 'details',
                'label' => __('Details', "comporisons"),
                'position' => 'normal',
                'metadata' => array(
                    array(
                        'slug' => 'brand_in_list',
                        'label' => __('Add Column', "comporisons"),
                        'type' => 'repeater',
                        'tab_class' => 'field_10',
                        'fields' => array(
                            array(
                                'slug' => 'select_post',
                                'label' =>  __('Post select', "comporisons"),
                                'type' => 'select',
                                'options' => self::get_brands(),
                            ),
                            array(
                                'slug' => 'brand_position',
                                'label' => __('Brand position(Rank)', "comporisons"),
                                'type' => 'text'
                            ),
                            array(
                                'slug' => 'brand_other_link',
                                'label' =>  __('Other links visibility', "comporisons"),
                                'type' => 'select',
                                'options' => array(
                                    'hide' => 'null',
                                    'show' => 'show',
                                ),
                            ),
                        ),
                    ),
             
                    /*array(
                        'slug' => 'color_picker',
                        'label' => __('Color picker', "comporisons"),
                        'type' => 'color',
                        'tab_class' => 'field_11'
                    ),*/
                    array(
                        'slug' => 'table_heading_color',
                        'label' => __('Table Heading Color', "comporisons"),
                        'type' => 'color',
                        'tab_class' => 'field_11'
                    ),
                    array(
                        'slug' => 'column_more_info',
                        'label' => __('Add Column', "comporisons"),
                        'type' => 'repeater',
                        'tab_class' => 'field_11',
                        'fields' => array(
                            array(
                                'slug' => 'column_title',
                                'label' =>  __('Title', "comporisons"),
                                'type' => 'text',
                            ),
                            /*array(
                                'slug' => 'column_bg_color',
                                'label' => __('BG Column Color', "comporisons"),
                                'type' => 'text'
                            ),*/
                            array(
                                'slug' => 'column_title_color',
                                'label' => __('Title Column Color', "comporisons"),
                                'type' => 'text'
                            ),
                            array(
                                'slug' => 'column_font_weight',
                                'label' =>  __('Font Weight', "comporisons"),
                                'type' => 'text',
                            ),
                            array(
                                'slug' => 'column_font_size',
                                'label' =>  __('Font Size', "comporisons"),
                                'type' => 'text',
                            ),
                            array(
                                'slug' => 'column_mobile_font_size',
                                'label' =>  __('Mobile Font Size', "comporisons"),
                                'type' => 'text',
                            ),
                            array(
                                'slug' => 'name_on_mobile',
                                'label' =>  __('Name on mobile', "comporisons"),
                                'type' => 'select',
                                'options' => array(
                                    'hide' => 'null',
                                    'show' => 'show',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'slug' => 'other_links',
                        'label' =>  __('Other links visibility (default)', "comporisons"),
                        'type' => 'select',
                        'tab_class' => 'field_12',
                        'options' => array(
                            'hide' => 'null',
                            'show' => 'show',
                        ),
                    ),
                    array(
                        'slug' => 'brand_title_color',
                        'label' => __('Brands Title Color', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12'
                    ),
                    array(
                        'slug' => 'brand_font_weight',
                        'label' =>  __('Brands Font Weight', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'brand_font_size',
                        'label' =>  __('Brands Font Size', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'brand_mobile_font_size',
                        'label' =>  __('Brands Mobile Font Size', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    
                    array(
                        'slug' => 'col_3_title_color',
                        'label' => __('Column 3 Title Color', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12'
                    ),
                    array(
                        'slug' => 'col_3_font_weight',
                        'label' =>  __('Column 3 Font Weight', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'col_3_font_size',
                        'label' =>  __('Column 3 Font Size', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'col_3_mobile_font_size',
                        'label' =>  __('Column 3 Mobile Font Size', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'col_4_5_title_color',
                        'label' => __('Column 4/5 Title Color', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12'
                    ),
                    array(
                        'slug' => 'col_4_5_font_weight',
                        'label' =>  __('Column 4/5 Title Font Weight', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'col_4_5_font_size',
                        'label' =>  __('Column 4/5 Title Font Size', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'buttons_text',
                        'label' =>  __('Default buttons text', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_12',
                    ),
                    array(
                        'slug' => 'top_bar_visib',
                        'label' =>  __('Top bar visibility', "comporisons"),
                        'type' => 'select',
                        'tab_class' => 'field_13',
                        'options' => array(
                            'hide' => 'null',
                            'show' => 'show',
                        ),
                    ),
                    array(
                        'slug' => 'top_bar_title_color',
                        'label' => __('Top Bar All Text Color', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_13'
                    ),
                    array(
                        'slug' => 'top_bar_bg_title_color',
                        'label' => __('Top Bar BG Color', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_13'
                    ),
                    array(
                        'slug' => 'top_bar_font_weight',
                        'label' =>  __('Top Bar Font Weight', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_13',
                    ),
                    array(
                        'slug' => 'top_bar_font_size',
                        'label' =>  __('Top Bar Font Size', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_13',
                    ),
                    array(
                        'slug' => 'top_bar_mobile_font_size',
                        'label' =>  __('Top Bar Mobile Font Size', "comporisons"),
                        'type' => 'text',
                        'tab_class' => 'field_13',
                    ),
                    
                    array(
                        'slug' => 'top_bar_info',
                        'label' => __('Add Column', "comporisons"),
                        'type' => 'repeater',
                        'tab_class' => 'field_13',
                        'fields' => array(
                            array(
                                'slug' => 'top_bar_title',
                                'label' =>  __('Title', "comporisons"),
                                'type' => 'text',
                            ),
                            array(
                                'slug' => 'top_bar_link',
                                'label' => __('Link', "comporisons"),
                                'type' => 'text'
                            ),
                            array(
                                'slug' => 'top_bar_link_color',
                                'label' => __('Link Color', "comporisons"),
                                'type' => 'text'
                            ),
                        ),
                    ),
                ),
                'tabs' => array(
                    array(
                        'key' => 'field_10',
                        'label' => 'Brands',
                    ),
                    array(
                        'key' => 'field_11',
                        'label' => 'Columns header settings',
                    ),
                    array(
                        'key' => 'field_12',
                        'label' => 'Additional settings',
                    ),
                    array(
                        'key' => 'field_13',
                        'label' => 'Top bar',
                    ),

                ),
            ),
        );
    }

    /**
     * Add metaboxes.
     */
    public static function co_add_event_metaboxes()
    {
        $post_type_slug = 'com_comporison_list';

        foreach (self::get_list_metaboxes() as $metabox) {

            $metabox_id = $post_type_slug . '_metabox_' . $metabox['slug'];
            $metabox_label = $metabox['label'];
            $metabox_callback = array(Comparison_List_Metabox::class, 'create_ctp_list_custom_metadata');
            $metabox_screen = $post_type_slug;
            $metabox_content = 'normal';
            $metabox_priority = 'default';
            $metabox_callback_args = array($metabox['metadata'], $post_type_slug);

            add_meta_box($metabox_id, $metabox_label, $metabox_callback, $metabox_screen, $metabox_content, $metabox_priority, $metabox_callback_args);
        }
    }

    public static function create_ctp_list_custom_metadata($post, $data)
    {

        global $admin_colors;
        $metabox = self::get_list_metaboxes();
        $metadata = $data['args'][0];
        $post_type_slug = $data['args'][1];

        $html = '<ul class="com-tab-group">';
        foreach ($metabox[0]['tabs'] as $key => $element) {
            $html .= '<li class="' . ($key === 0 ? 'active' : '') . ' ' . $element['key'] . '">
                <a href="" class="com-tab-button" data-endpoint="0" data-key="' . $element['key'] . '">' . __($element['label'], 'comporisons') . '</a>
                </li>';
        }

        $html .= '</ul>';

        foreach ($metadata as $metadatum) {

            $html .= '<div class="metadata-wrap ' . $metadatum['tab_class'] . ' ' . ($metadatum['tab_class'] === 'field_10' ? 'active' : 'hidden 1')  . '">';


            $metadatum_type = array_key_exists('type', $metadatum) ? $metadatum['type'] : 'text';
            $metadatum_label = array_key_exists('label', $metadatum) ? $metadatum['label'] : '';
            $metadatum_desc = array_key_exists('desc', $metadatum) ? $metadatum['desc'] : '';
            $metadatum_slug = array_key_exists('slug', $metadatum) ? $metadatum['slug'] : '';
            $metadatum_default = array_key_exists('default', $metadatum) ? $metadatum['default'] : '';
            $metadatum_options = array_key_exists('options', $metadatum) ? $metadatum['options'] : '';
            $metadatum_tab_class = array_key_exists('tab_class', $metadatum) ? $metadatum['tab_class'] : '';
            $metadatum_fields = array_key_exists('fields', $metadatum) ? $metadatum['fields'] : '';
            $metadatum_id = $post_type_slug . '_metadata_' . $metadatum_slug;
            $metadatum_value = get_post_meta($post->ID, $metadatum_id, true);
            $metadatum_value = $metadatum_value ? $metadatum_value : $metadatum_default;

            register_meta($post_type_slug, $metadatum_id, array(
                'single' => true,
                'show_in_rest' => true
            ));

            switch ($metadatum_type) {

                case 'hidden':

                    $html .= '<input type="hidden" name="' . $metadatum_id . '" id="' . $metadatum_id . '" value="' . $metadatum_value . '" class="widefat" />';

                    break;

                case 'number':
                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<input ' . (isset($metadatum['required']) ? 'required' : '') . ' type="number" min="' . $metadatum['min'] . '" max="' . $metadatum['max'] . '"  name="' . $metadatum_id . '" id="' . $metadatum_id . '" value="' . $metadatum_value . '" data-tabclass="' . $metadatum_tab_class . '" class="widefat" />';

                    break;

                case 'select':

                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<select ' . (isset($metadatum['required']) ? 'required' : '') . ' name="' . $metadatum_id . '" id="' . $metadatum_id . '" data-tabclass="' . $metadatum_tab_class . '" class="widefat">';

                    foreach ($metadatum_options as $metadatum_option_label => $metadatum_option_value) {

                        $html .= '<option' . ($metadatum_option_value == $metadatum_value ? ' selected="selected"' : '') . ' value="' . $metadatum_option_value . '">' . $metadatum_option_label . '</option>';
                    }

                    $html .= '</select>';

                    break;

                case 'textarea':

                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<textarea ' . (isset($metadatum['required']) ? 'required' : '') . ' name="' . $metadatum_id . '" id="' . $metadatum_id . '" data-tabclass="' . $metadatum_tab_class . '" class="widefat">' . $metadatum_value . '</textarea>';

                    break;


                case 'file':
                    $image_url = '';

                    if ($metadatum_value !== '') {

                        $image_url = wp_get_attachment_url($metadatum_value);
                    }

                    $html .= '
                    <style>
                    .com_upload_image {
                        max-width:100px;
                    }
                    .com_upload_image_remove {
                        display:block;
                    }
                    </style><p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<button ' . ($image_url !== '' ? 'style="display: none"' : '') . ' class="com_upload_image button button-primary button-large" name="' . $metadatum_id . '" id="' . $metadatum_id . '" data-tabclass="' . $metadatum_tab_class . '">' . __('Upload', 'comporisons') . '</button>';


                    $html .= '<input name="' . $metadatum_id . '"
						type="hidden"
						class="com_upload_image_save"
                        value="' . $metadatum_value . '"
					/>				
					<img src="' . ($image_url !== '' ? $image_url : '') . '"					
						style="width: 300px;"
						alt=""
						class="com_upload_image_show"
						' . ($image_url == '' ? 'style="display: none;"' : '') . '/>					
					<a
						href="#"
						class="com_upload_image_remove"
						' . ($image_url == '' ? 'style="display: none;"' : '') . '>Remove Image</a>';

                    break;

                case 'wp_editor':

                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';


                    ob_start();
                    // $html .= '<textarea ' . (isset($metadatum['required']) ? 'required' : '') . ' name="' . $metadatum_id . '" id="' . $metadatum_id . '" class="widefat">' . $metadatum_value . '</textarea>';
                    wp_editor($metadatum_value, $metadatum_id, array(
                        'textarea_name' => $metadatum_id,
                        'textarea_rows' => 15,
                        'media_buttons' => true,
                        'tinymce' => array(
                            /*'setup' => 'function(ed) {
                                ed.onInit.add(function(ed) {
                                    ed.execCommand("fontName", false, "Vietnam");
                                    ed.execCommand("fontSize", false, "2");
                                });
                            }',*/
                            'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                            'toolbar2' => 'formatselect,fontsizeselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
                            'toolbar3' => 'fontselect',
                        ),



                    ));
                    $html .= ob_get_clean();

                    break;
                case 'toggle':

                    $html .= '
                        <style>
                            toggle::after {
                                display:block;
                                clear:both;
                                content:"";
                            }
                            toggle input {
                                position:absolute;
                                left:-99999999px;
                            }
                            toggle svg {
                                height:20px;
                                width:20px;
                                display:block;
                            }
                            toggle label div {
                                display:block;
                                float:left;
                                padding:6px 12px;
                                border:solid 1px rgb(160,160,160);
                                fill:gray;
                                position: relative;
                            }
                            toggle label:first-child div {
                                border-radius:5px 0 0 5px;
                                left: 1px;
                            }
                            toggle label:last-child div {
                                border-radius:0 5px 5px 0;
                                right: 1px;
                            }
                            toggle input:checked ~ div {
                                color:white;
                                fill:white;
                                background-color: #135e96;
                                border-color: #135e96;
                                z-index:1;
                            }
                        </style>';

                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<toggle>';

                    foreach ($metadatum_options as $key => $metadatum_option) {
                        $html .= '<label><input data-tabclass="' . $metadatum_tab_class . '" ' . (isset($metadatum['required']) ? 'required' : '') . ' type="radio" name="' . $metadatum_id . '"' . ($metadatum_option == $metadatum_value ? ' checked="checked"' : '') . ' value="' . $metadatum_option . '" /><div>' . $key . '</div></label>';
                    }

                    $html .= '</toggle>';

                    break;

                case 'color':

                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<input type="text" name="' . $metadatum_id . '" id="' . $metadatum_id . '" value="' . $metadatum_value . '" data-tabclass="' . $metadatum_tab_class . '" class="widefat color_field" />';

                    break;

                case 'repeater':

                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<table id="repeatable-fieldset-one" width="100%"><thead><tr>';

                    foreach ($metadatum_fields as $field) {
                        $html .= '<th width="' . 100 / count($metadatum_fields) . '%">' . __($field['label'], 'comporisons') . '</th> ';
                    }
                    $html .= '</tr></thead><tbody>';
                    $field_name = 'repeater_' . $metadatum['slug'] . '_field';
                    $serialize_data = get_post_meta($post->ID, $metadatum_id, true);
                    $repeatable_fields = [];

                    for ($meta_i = 0; $meta_i < count($metadatum['fields']); $meta_i++) {

                        if ($serialize_data) {
                            $data = unserialize($serialize_data);

                            if (is_array($data)) {

                                foreach ($data as $key => $value) {
                                    $repeatable_fields[$key] = $value;
                                }
                            } else {
                                $repeatable_fields[] = stripslashes(strip_tags($data));
                            }
                        }
                    }

                    if ($repeatable_fields) :

                        foreach ($repeatable_fields as $field) {
                            $html .= '<tr>';

                            for ($i = 0; $i < count($field); $i++) {
                                $field_id = $field_name . '_' . $metadatum['fields'][$i]['slug'];

                                if ($field[$field_id]) {
                                    if ($field[$field_id]['type'] === 'text') {
                                        $html .= '<td><input type="text" class="widefat" name="' . $field_name . '_' . $metadatum['fields'][$i]['slug'] . '[]" value="' . $field[$field_id]['data'] . '" /></td>';
                                    } elseif ($field[$field_id]['type'] === 'select') {
                                        $html .= '<td><select name="' . $field_name . '_' . $metadatum['fields'][$i]['slug'] . '[]" class="widefat">';

                                        foreach ($metadatum['fields'][$i]['options'] as $option_label => $option_value) {

                                            $html .= '<option' . ($option_value === $field[$field_id]['data'] ? ' selected="selected"' : '') . ' value="' . $option_value . '">' . $option_label . '</option>';
                                        }

                                        $html .= '</select></td>';
                                    }
                                }
                            }
                            $html .= '<td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>';
                        }

                    else :
                        // show a blank one   
                        $html .= '<tr>' . self::repeater_field_generate_helper($metadatum_fields, $field_name, $metadatum_tab_class) . '</tr>';
                    endif;

                    $html .= '<!-- empty hidden one for jQuery --><tr class="empty-row screen-reader-text">';
                    $html .= self::repeater_field_generate_helper($metadatum_fields, $field_name, $metadatum_tab_class);
                    $html .= '<td><a class="button remove-row" href="#">Remove</a></td></tr>
                    </tbody>
                    </table>
                    <p><a class="button add-row" href="#">Add another</a></p>';

                    break;

                default:

                    $html .= '<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="' . $metadatum_id . '">' . $metadatum_label . (isset($metadatum['required']) ? ' *' : '') . '</label></p>';

                    $html .= '<div class="metadata-desc">' . $metadatum_desc . '</div>';

                    $html .= '<input ' . (isset($metadatum['required']) ? 'required' : '') . ' type="' . $metadatum_type . '" name="' . $metadatum_id . '" id="' . $metadatum_id . '" value="' . $metadatum_value . '" data-tabclass="' . $metadatum_tab_class . '" class="widefat" />';

                    break;
            }

            $html .= '</div>';
        }

        echo $html . '<input type="hidden" name="custommeta_noncename" id="custommeta_noncename" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    }

    public static function repeater_field_generate_helper($metadatum_fields, $field_name, $tab_class = '')
    {
        $html = '';
        foreach ($metadatum_fields as $field) {

            if ($field['type'] === 'text') {
                $html .= '<td><input type="text" class="widefat" data-tabclass="' . $tab_class . '" name="' . $field_name . '_' . $field['slug'] . '[]" /></td>';
            } elseif ($field['type'] === 'select') {
                $html .= '<td><select name="' . $field_name . '_' . $field['slug'] . '[]" class="widefat" data-tabclass="' . $tab_class . '">';

                foreach ($field['options'] as $option_label => $option_value) {
                    $html .= '<option' . ($option_label == array_key_first($field['options']) ? ' selected="selected"' : '') . ' value="' . $option_value . '">' . $option_label . '</option>';
                }
                $html .= '</select></td>';
            }
        }

        return $html;
    }

    public function save_ctp_custom_metadata()
    {
        global $post;

        if (empty($_POST["custommeta_noncename"])) {
            return;
        }
        if (!wp_verify_nonce($_POST['custommeta_noncename'], basename(__FILE__))) {
            return;
        }
        if (!current_user_can('edit_post', $post->ID)) {
            return;
        }
        if ($post->post_type == 'revision') {
            return;
        }

        $post_type_slug = get_post_type($post);
        $metadata_id = '';
        $metadata_object = array();

        foreach (self::get_list_metaboxes() as $metabox) {

            foreach ($metabox['metadata'] as $metadatum) {
                $metadata_id = $post_type_slug . '_metadata_' . $metadatum['slug'];
                $metadata_object[$metadata_id] = isset($_POST[$metadata_id]) ? $_POST[$metadata_id] : [];

                if ($metadatum['type'] == 'repeater') {
                    $metadata_repeater_id = 'repeater_' . $metadatum['slug'] . '_field_';

                    $new = array();
                    $meta_i = 0;

                    for (; $meta_i < count($metadatum['fields']); $meta_i++) {
                        $field_slug = $metadata_repeater_id . $metadatum['fields'][$meta_i]['slug'];
                        $data = $_POST[$field_slug];

                        if ($data) {
                            if (is_array($data)) {

                                for ($i = 0; $i < count(array_slice($data, 0, -1)); $i++) {
                                    $new[$i][$field_slug]['data'] =  $data[$i] != '' ? stripslashes(strip_tags($data[$i])) : '';
                                    $new[$i][$field_slug]['type'] = $metadatum['fields'][$meta_i]['type'];
                                }
                            } else {
                                $new[0][$field_slug] = stripslashes(strip_tags($data));
                            }
                        }
                    }
                    $metadata_object[$metadata_id] =  $new;
                }
            }
        }

        self::save_ctp_metadata_object($metadata_object, $post->ID);
    }

    public static function save_ctp_metadata_object($metadata_object, $post_ID)
    {
        foreach ($metadata_object as $key => $value) {
            //$value = implode(',', (array)$value);
            if (get_post_meta($post_ID, $key, FALSE)) {
                update_post_meta($post_ID, $key, is_array($value) ? serialize($value) : $value);
            } else {
                add_post_meta($post_ID, $key, is_array($value) ? serialize($value) : $value);
            }
            if (!$value) {
                delete_post_meta($post_ID, $key);
            }
        }
    }


    public static function register_save_events_meta()
    {
        /**
         * Save the metabox data
         */
        function wpt_list_save_events_meta($post_id, $post)
        {
            // Return if the user doesn't have edit permissions.
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            // Verify this came from the our screen and with proper authorization,
            // because save_post can be triggered at other times.
            if (!isset($_POST['location']) || !wp_verify_nonce($_POST['com_comporison_fields'], basename(__FILE__))) {
                return $post_id;
            }

            // Now that we're authenticated, time to save the data.
            // This sanitizes the data from the field and saves it into an array $events_meta.
            $events_meta['location'] = esc_textarea($_POST['location']);

            // Cycle through the $events_meta array.
            // Note, in this example we just have one item, but this is helpful if you have multiple.
            foreach ($events_meta as $key => $value) :

                // Don't store custom data twice
                if ('revision' === $post->post_type) {
                    return;
                }

                if (get_post_meta($post_id, $key, false)) {
                    // If the custom field already has a value, update it.
                    update_post_meta($post_id, $key, $value);
                } else {
                    // If the custom field doesn't have a value, add it.
                    add_post_meta($post_id, $key, $value);
                }

                if (!$value) {
                    // Delete the meta key if there's no value
                    delete_post_meta($post_id, $key);
                }

            endforeach;
        }
        add_action('save_post_com_comporison_list', 'wpt_list_save_events_meta', 1, 2);
    }
}
