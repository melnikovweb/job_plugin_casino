<?php
class ComparisonHtml
{
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $comparison    The string used to uniquely identify this plugin.
     */
    protected $comparison;

    /**
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $comparison_metabox
     */
    protected $comparison_metabox;

    /**
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $comparison_list_metabox
     */
    protected $comparison_list_metabox;

    /**
     * Define metabox core
     *
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->comparison = 'com_comporison';
    }

    public function get_list_html($wp_query, $count = 15, $offset = 0)
    {
        $html = '';
        if ($wp_query) {
            while ($wp_query->have_posts() && $count-- > 0) {
                $wp_query->the_post();
                if ($offset-- > 0) {
                    continue;
                }

                $this->comparison_metabox = $this->metabox_transform_to_array(get_the_ID());
                $is_highlight = (isset($this->comparison_metabox['highlight']) && $this->comparison_metabox['highlight']) ? true : false;
                //render Comparison card
                $html .= '<div class="com-comparison' . ($is_highlight ? ' highlight' : '') . (defined('JSON_REQUEST') ? ' com-animated' : '') . '"
                 style="background-color:' . $this->comparison_metabox['card_bg_color'] . '">
				<div class="com-comparison-wrap">';
                $html .= $this->get_html_logo_block($is_highlight);
                $html .= '<div class="com-compatison-content__container"><div class="com-comparison-characteristics">';
                $html .= $this->get_html_characteristics_block();
                $html .= "</div>";
                $html .= $this->get_html_promote_block();
                $html .= $this->get_html_price_block();
                $html .= $this->get_html_submit_block();
                $html .= '</div></div>';
                $html .= $this->get_html_terms_block();
                $html .= '</div>';
                $html .= $this->get_html_other_links();
            }
            // Restore original Post Data
            wp_reset_postdata();
        }
        return $html;
    }

    // render list shortcode
    public function get_list_html_v2($wp_query, $list_id, $count = 15, $offset = 0)
    {
        $comparison_list_metabox = self::metabox_list_transform_to_array($list_id);

        if ($comparison_list_metabox) {
            $html = '';
            $html .= '<table class="comparison-bonus-list" width="100%">';
            $html .= '
        <thead><tr 
        ' . (!empty($comparison_list_metabox['table_heading_color']) ? 'style="background-color:' . $comparison_list_metabox['table_heading_color'] . '!important;"' : '') . '
        class="cbl-sort">';

            $column_num = 1;
            foreach ($comparison_list_metabox['column_more_info'] as $key => $value) {

                $html .= '<th class="cbl-col-' . $column_num . '">' . $value['column_title'];
                $html .= '
            <style>thead .cbl-col-' . $column_num . '{' .
                    (!empty($value['column_title_color']) ? 'color:' . $value['column_title_color'] . '!important;' : '') .
                    //(!empty($value['column_bg_color']) ? 'background-color:'.$value['column_bg_color'].'!important;' : '') .
                    (!empty($value['column_font_weight']) ? 'font-weight:' . $value['column_font_weight'] . '!important;' : '') .
                    (!empty($value['column_font_size']) ? 'font-size:' . $value['column_font_size'] . '!important;' : '') .
                    '@media (max-width: 768px){' .
                    (!empty($value['column_mobile_font_size']) ? 'font-size:' . $value['column_mobile_font_size'] . '!important;' : '');
                if ($value['name_on_mobile'] !== 'show') {
                    $html .= 'display:none!important;';
                }
                $html .= '}}</style></th>';
                $column_num++;
            }

            $html .= '<th class="cbl-button"></th></tr></thead><tbody class="com_comparision_table-container">';

            if ($comparison_list_metabox['top_bar_visib'] == 'show') {
                $html .= '<tr class="general-terms">';
                $html .= $this->get_html_top_bar_info($comparison_list_metabox);
                $html .= '</tr>';
            }


            $html .= $this->get_list_row_html_v2($wp_query, $list_id, $count, $offset);

            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '<style>.cbl-col-2 h4{';
            if (!empty($comparison_list_metabox['brand_title_color'])) {
                $html .= 'color:' . $comparison_list_metabox['brand_title_color'] . ';';
            }
            if (!empty($comparison_list_metabox['brand_font_weight'])) {
                $html .= 'font-weight:' . $comparison_list_metabox['brand_font_weight'] . ';';
            }
            if (!empty($comparison_list_metabox['brand_font_size'])) {
                $html .= 'font-size:' . $comparison_list_metabox['brand_font_size'] . ';';
            }
            $html .= '}';
            if (!empty($comparison_list_metabox['brand_mobile_font_size'])) {
                $html .= '@media (max-width: 768px){.cbl-col-2 h4{font-size:' . $comparison_list_metabox['brand_mobile_font_size'] . ';}}';
            }
            $html .= '.cbl-col-3 p{';
            if (!empty($comparison_list_metabox['col_3_title_color'])) {
                $html .= 'color:' . $comparison_list_metabox['col_3_title_color'] . ';';
            }
            if (!empty($comparison_list_metabox['col_3_font_weight'])) {
                $html .= 'font-weight:' . $comparison_list_metabox['col_3_font_weight'] . ';';
            }
            if (!empty($comparison_list_metabox['col_3_font_size'])) {
                $html .= 'font-size:' . $comparison_list_metabox['col_3_font_size'] . ';';
            }
            $html .= '}';
            if (!empty($comparison_list_metabox['col_3_mobile_font_size'])) {
                $html .= '@media (max-width: 768px){.cbl-col-2 h4{font-size:' . $comparison_list_metabox['col_3_mobile_font_size'] . ';}}';
            }
            $html .= '</style>';
            return $html;
        }
        return '<div>list does not exist</div>';
    }

    public function get_list_row_html_v2($wp_query, $list_id, $count = 15, $offset = 0)
    {
        $comparison_list_metabox = self::metabox_list_transform_to_array($list_id);
        $html = '';
        $posts_ids = [];

        foreach ($comparison_list_metabox['brand_in_list'] as $key => $value) {
            array_push($posts_ids, ["brand_position" => $value['brand_position'], "brand_id" => $value['select_post'], "brand_other_link" => $value['brand_other_link']]);
        }

        asort($posts_ids);

        $posts_rank = [];
        $brand_other_link = [];

        foreach ($posts_ids as $key => $value) {
            array_push($posts_rank, $value["brand_position"]);
            array_push($brand_other_link, $value["brand_other_link"]);
        }

        $q = $wp_query; ///new WP_Query($args);

        $it = 0;
        if ($q) {
            while ($q->have_posts() && $count-- > 0) {
                $q->the_post();
                if ($offset-- > 0) {
                    $it++;
                    continue;
                }

                $html .= '<tr class="item item-' . $posts_rank[$it] . '' . (defined('JSON_REQUEST') ? ' com-animated' : '') .'">';
                $this->comparison_metabox = $this->metabox_transform_to_array(get_the_ID());
                $is_highlight = (isset($this->comparison_metabox['highlight']) && $this->comparison_metabox['highlight']) ? true : false;
                //render Comparison card
                if (!empty($this->comparison_metabox['custom_columns_text'])) {
                    foreach ($this->comparison_metabox['custom_columns_text'] as $key => $value) {
                        if ($value['select_list'] == $list_id) {
                            $custom_col_txt_4 = $value['column_text_4'];
                            $custom_col_txt_5 = $value['column_text_5'];
                        }
                    }
                }

                foreach ($comparison_list_metabox['column_more_info'] as $key => $value) {
                    $style_4_5 = "";
                    if (!empty($comparison_list_metabox['col_4_5_title_color'])) {
                        $style_4_5 .= 'color:' . $comparison_list_metabox['col_4_5_title_color'] . ';';
                    }
                    if (!empty($comparison_list_metabox['col_4_5_font_weight'])) {
                        $style_4_5 .= 'font-weight:' . $comparison_list_metabox['col_4_5_font_weight'] . ';';
                    }
                    if (!empty($comparison_list_metabox['col_4_5_font_size'])) {
                        $style_4_5 .= 'font-size:' . $comparison_list_metabox['col_4_5_font_size'] . ';';
                    }

                    if ($key == 0) {
                        $html .= '<td class="column cbl-col-1"><span>';

                        $html .= $posts_rank[$it];


                        $html .= '</span></td>';
                    }
                    if ($key == 1) {

                        $html .= '<td class="column cbl-col-2">';
                        if (!empty($this->comparison_metabox['litle_icon'])) {
                            $html .= '<a href="' .  get_permalink() . '" rel="nofollow" target="_blank" title="' . get_the_title() . '" class="comparison-brand-link">';
                            $is_highlight && $html .= $this->get_html_highlight_svg();
                            $html .= '<img alt="' . get_the_title() . '" class=" lazyloaded" src="' . $this->comparison_metabox['litle_icon'] . '">';
                        } else {
                            $html .= '<a href="' .  get_permalink() . '" rel="nofollow" target="_blank" title="' . get_the_title() . '" class="comparison-brand-link">';
                            $is_highlight && $html .= $this->get_html_highlight_svg();
                            $html .= (has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), [50, 'auto']) : '');
                        }
                        $html .= $this->get_html_characteristics_block_v2();
                        $html .= '</a></td>';
                    }
                    if ($key == 2) {
                        $html .= '<td class="column cbl-col-3"><p>';

                        $html .= (!empty($this->comparison_metabox['amount_details']) ?  $this->comparison_metabox['amount_details'] : '')  . '</p></td>';
                    }
                    if ($key == 3) {
                        if (!empty($this->comparison_metabox['list_col_4'])) {
                            $html .= '<td class="column cbl-col-4">';
                            $html .= '<p  class="com__extra-title">';
                            if ($value['name_on_mobile'] == 'show') {
                                $html .= '<span'. ($style_4_5 ? ' style="'.$style_4_5 . '"' : "") .'>' . $value['column_title'] . ': </span>';
                            }
                            $html .= (!empty($custom_col_txt_4) ? $custom_col_txt_4 : $this->comparison_metabox['list_col_4']) . '&nbsp;</p>';
                            $html .= '</td>';
                        }
                    }
                    if ($key == 4) {

                        if (!empty($this->comparison_metabox['list_col_5'])) {
                            $html .= '<td class="column cbl-col-5">';
                            $html .= '<p  class="com__extra-title">';
                            if ($value['name_on_mobile'] == 'show') {
                                $html .= '<span'. ($style_4_5 ? ' style="'.$style_4_5 . '"' : "") .'>' . $value['column_title'] . ': </span>';
                            }
                            $html .= (!empty($custom_col_txt_5) ? $custom_col_txt_5 : $this->comparison_metabox['list_col_5']) . '&nbsp;</p>';
                            $html .= '</td>';
                        }
                    }
                   /* if ($key == 5) {
                        $html .= '<td class="column cbl-col-6">';
                        if (!empty($this->comparison_metabox['list_col_6'])) {
                            $html .= '<p  class="com__extra-title">';
                            if ($value['name_on_mobile'] == 'show') {
                                $html .= '<span>' . $value['column_title'] . ': </span>';
                            }
                            $html .= (!empty($custom_col_txt_6) ? $custom_col_txt_6 : $this->comparison_metabox['list_col_6']) . '&nbsp;</p>';
                        }
                        $html .= '</td>';
                    }*/
                }

                $html .= $this->get_html_submit_block_v2(!empty($comparison_list_metabox['buttons_text']) ? $comparison_list_metabox['buttons_text']  : '');

                if (is_array($this->comparison_metabox['preference_text'])) {
                    $desc =  !empty($this->comparison_metabox['description']) ? $this->comparison_metabox['description'] : '';

                    $html .= '<td class="column cbl-list ' . (!$desc ? 'full' : '') . '">';
                    $html .= $this->get_html_characteristics_list_block();
                    $html .= $desc ? '<div class="comparison-promote__img">' . $desc . '</div>' : '';
                    $html .= '</td>';
                }

                if ($comparison_list_metabox['other_links'] == 'show') {
                    if ($brand_other_link[$it] == 'show') {
                        $html .= '<td class="cbl-terms">';
                        $html .= $this->get_html_other_links();
                        $html .= '</td>';
                    }
                }
                $html .= '</tr>';
                $it++;
                $custom_col_txt_4 = '';
                $custom_col_txt_5 = '';
            }
            // Restore original Post Data
            wp_reset_postdata();
        }

        return $html;
    }

    /** return highlight svg */
    private function get_html_highlight_svg()
    {
        return '<svg class="comparison__highlight_svg" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="256" x2="256" y1="512" y2="0"><stop offset="0" stop-color="#fd5900"/><stop offset="1" stop-color="#ffde00"/></linearGradient><linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="256" x2="256" y1="451.998" y2="242.004"><stop offset="0" stop-color="#ffe59a"/><stop offset="1" stop-color="#ffffd5"/></linearGradient><g><g><g><path d="m397.343 158.387c-4.658-2.153-10.093-1.787-14.399.938-4.321 2.754-6.943 7.529-6.943 12.656v25.019c0 8.276-6.724 15-15 15-7.412 0-13.682-5.332-14.897-12.583-12.204-75.645-67.78-199.417-90.104-199.417s-77.9 123.772-90.088 199.329c-1.23 7.339-7.5 12.671-14.912 12.671-8.276 0-15-6.724-15-15v-25.02c0-5.127-2.622-9.902-6.943-12.656-4.321-2.725-9.727-3.091-14.399-.938-51.065 23.819-83.658 127.618-83.658 188.614 0 97.148 92.52 165 225 165s225-67.852 225-165c0-60.996-32.593-164.795-83.657-188.613z" fill="url(#SVGID_1_)"/></g></g><g><g><path d="m328.759 309.119c-2.739-4.424-7.559-7.119-12.759-7.119h-33.281l-12.173-48.633c-1.523-6.094-6.665-10.591-12.905-11.279-6.372-.659-12.246 2.607-15.059 8.203l-60 120c-2.329 4.644-2.08 10.166.659 14.59s7.559 7.119 12.759 7.119h33.281l12.173 48.633c1.523 6.094 6.665 10.591 12.905 11.279 6.419.676 12.307-2.715 15.059-8.203l60-120c2.329-4.644 2.08-10.166-.659-14.59z" fill="url(#SVGID_2_)"/></g></g></g></svg>';
    }

    /** render html stars block */
    private function get_html_stars_block()
    {
        $html = '<div class="com-comparison-stars">';
        for ($i = 0; $i < 5; $i++) {
            $html .= $i < $this->comparison_metabox['rating']
                ? '<span class="com-comparison__fill-star"><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.04894 0.92705C7.3483 0.00573921 8.6517 0.00573969 8.95106 0.92705L10.0206 4.21885C10.1545 4.63087 10.5385 4.90983 10.9717 4.90983H14.4329C15.4016 4.90983 15.8044 6.14945 15.0207 6.71885L12.2205 8.75329C11.87 9.00793 11.7234 9.4593 11.8572 9.87132L12.9268 13.1631C13.2261 14.0844 12.1717 14.8506 11.388 14.2812L8.58778 12.2467C8.2373 11.9921 7.7627 11.9921 7.41221 12.2467L4.61204 14.2812C3.82833 14.8506 2.77385 14.0844 3.0732 13.1631L4.14277 9.87132C4.27665 9.4593 4.12999 9.00793 3.7795 8.75329L0.979333 6.71885C0.195619 6.14945 0.598395 4.90983 1.56712 4.90983H5.02832C5.46154 4.90983 5.8455 4.63087 5.97937 4.21885L7.04894 0.92705Z" fill="' . $this->getMetabox('rating_color', '#F0544F') . '"/>
            </svg></span>' :
                '<span class="com-comparison__empty-star"><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.04894 0.92705C7.3483 0.00573921 8.6517 0.00573969 8.95106 0.92705L10.0206 4.21885C10.1545 4.63087 10.5385 4.90983 10.9717 4.90983H14.4329C15.4016 4.90983 15.8044 6.14945 15.0207 6.71885L12.2205 8.75329C11.87 9.00793 11.7234 9.4593 11.8572 9.87132L12.9268 13.1631C13.2261 14.0844 12.1717 14.8506 11.388 14.2812L8.58778 12.2467C8.2373 11.9921 7.7627 11.9921 7.41221 12.2467L4.61204 14.2812C3.82833 14.8506 2.77385 14.0844 3.0732 13.1631L4.14277 9.87132C4.27665 9.4593 4.12999 9.00793 3.7795 8.75329L0.979333 6.71885C0.195619 6.14945 0.598395 4.90983 1.56712 4.90983H5.02832C5.46154 4.90983 5.8455 4.63087 5.97937 4.21885L7.04894 0.92705Z" fill="#CDCDCD"/>
            </svg>
            </span>';
        }
        return $html .= '</div>';
    }
    /** render html logo block */
    private function get_html_logo_block($is_highlight)
    {
        $html = '<div class="com-comparison-logo" style="background-color:' . $this->comparison_metabox['card_logo_bg_color'] . '">';
        if ($is_highlight) {
            $highlight_img_url = plugin_dir_url(__DIR__) . '/public/img/hilight_bg.png';
            $html .= '<span class="com-comparison__highlight-label"  
            style="background-image:url(' . $highlight_img_url . ');"><span>' . $this->comparison_metabox['highlight_label'] . '</span></span>';
        }
        $html .= $this->get_html_stars_block();
        if (!empty($this->comparison_metabox['logo_brand_label'])) {
            $html .= '<div class="com-comparison__brand-label">';
            if (!empty($this->comparison_metabox['logo_brand_label_link'])) {
                $html .= '<a style="color:' .
                    $this->comparison_metabox['logo_brand_label_color'] . '" href="' .
                    $this->comparison_metabox['logo_brand_label_link']
                    . '" rel="nofollow" target="_blank" class="com-comparison__brand-label--link" title="' .
                    $this->comparison_metabox['logo_brand_label'] . '">' . $this->comparison_metabox['logo_brand_label'] . '</a>';
            } else {
                $html .= '<span style="color:' .
                    $this->comparison_metabox['logo_brand_label_color'] . '">' . $this->comparison_metabox['logo_brand_label'] . '</span>';
            }
            $html .= '</div>';
        }
        $html .= '<div class="img-logo"><a href="' .  get_permalink() . '" rel="nofollow" target="_blank" title="' . get_the_title() . '">';
        $html .= (has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), [170, 'auto']) : '');
        $html .= '</a></div></div>';
        return $html;
    }

    /** render html characteristics block */
    private function get_html_characteristics_block()
    {
        $html = '
        <ul class="com-comparison-characteristics__list">';
        if (is_array($this->comparison_metabox['preference_text'])) {
            foreach ($this->comparison_metabox['preference_text'] as $value) {
                $html .= !empty($value['description']) ? '<li style="color:' . $this->getMetabox('preference_text_color', '#6f6f6f') . '">
            <svg xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="0 0 512 512" width="512pt">
                <path fill="' . $this->getMetabox('preference_color', '#F0544F') . '"  d="m512 256c0 141.386719-114.613281 256-256 256s-256-114.613281-256-256 114.613281-256 256-256 256 114.613281 256 256zm0 0" /><path d="m411.3125 196.6875-48-48c-6.25-6.246094-16.375-6.246094-22.625 0l-116.6875 116.679688-52.6875-52.679688c-6.25-6.246094-16.375-6.246094-22.625 0l-48 48c-6.246094 6.25-6.246094 16.375 0 22.625l96 96c3 3 7.070312 4.6875 11.3125 4.6875h32c4.242188 0 8.3125-1.6875 11.3125-4.6875l160-160c6.246094-6.25 6.246094-16.375 0-22.625zm0 0" fill="#fff"/>
            </svg>' . $value['description'] . '</li>' : '';
           }
        }
        return $html .= '</ul>';
    }

        /** render html characteristics list block */
        private function get_html_characteristics_list_block()
        {
            $html = '
            <ul class="com-comparison-characteristics__list">';
            if (is_array($this->comparison_metabox['preference_text'])) {
                foreach ($this->comparison_metabox['preference_text'] as $value) {
                    $html .= !empty($value['description']) ? '<li style="color:' . $this->getMetabox('preference_text_color', '#6f6f6f') . '">
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><linearGradient id="linear-gradient" gradientTransform="matrix(.707 .707 -.707 .707 256 -106.039)" 
                gradientUnits="userSpaceOnUse" x1="256" x2="256" y1="507.946" y2="4.054">
                <stop offset="0" stop-color="#5CFFAF"/><stop offset="1" stop-color="#D3FFD0"/></linearGradient>
                <linearGradient id="linear-gradient-2" gradientUnits="userSpaceOnUse" x1="256" x2="256" y1="-85.165" y2="596.964">
                <stop offset="0" stop-color="#009481"/>
                <stop offset="1" stop-color="#00DB8A"/>
                </linearGradient><circle cx="256" cy="256" 
                fill="url(#linear-gradient)" r="251.946" 
                transform="matrix(.707 -.707 .707 .707 -106.039 256)"/><path d="m109.006 241.955 23.805-23.811c3.681-3.684 8.424-5.297 13.599-4.611 5.166.677 9.331 3.46 11.938 7.978l43.496 75.34 163.101-163.108c3.379-3.379 7.727-4.855 12.467-4.232 4.742.632 8.555 3.178 10.944 7.314l17.453 30.231c4.348 7.532 3.136 16.722-3.007 22.862l-182.177 182.18c-8.148 8.145-18.61 11.701-30.029 10.197-11.422-1.51-20.605-7.644-26.37-17.62l-58.124-100.677c-4.194-7.26-3.027-16.116 2.905-22.042z" fill="url(#linear-gradient-2)" fill-rule="evenodd"/></svg>'
                . $value['description'] . '</li>' : '';
                }
            }
            return $html .= '</ul>';
        }
    private function get_html_characteristics_block_v2()
    {
        $html = '<div class="comparison-brand-wrap"><h4>' . get_the_title() . '</h4>';
        $html .= $this->get_html_stars_block() . '</div>';
        return $html;
    }

    /** render html promote block */
    private function get_html_promote_block()
    {
        return '<div class="com-comparison-promote">
            <div class="com-comparison-promote__text">
                <div class="com-comparison-promote__text_content">' . (!empty($this->comparison_metabox['description']) ? $this->comparison_metabox['description'] : '') . '</div>
            </div>
        </div>';
    }


    /** render html price block */
    private function get_html_price_block()
    {
        $html  = '<div class="com-comparison-price">';
        $html .= '<span class="com-comparison-price__number" style="color:' .  (!empty($this->comparison_metabox['amount_color']) ? $this->comparison_metabox['amount_color'] : '') . ';">' . (!empty($this->comparison_metabox['amount_details']) ?  $this->comparison_metabox['amount_details'] : '')  . '</span>';
        $html .= '<div class="com-comparison-price__other-container">';
        $html .= '<span class="com-comparison-price__brand">' . get_the_title() . '</span>';
        $html .= $this->get_html_stars_block();
        $html .= '</div></div>';

        return $html;
    }


    /** render html submit block */
    private function get_html_submit_block()
    {
        $html = '<div class="com-comparison-submit"><div class="com-comparison-wrapper">';
        if (!empty($this->comparison_metabox['select_btn_link'])) {
            $html .= '<a ' . (isset($this->comparison_metabox['select_btn_color']) ? ('style="background-color:' . $this->comparison_metabox['select_btn_color'] . '"') : '') .
                'href = "' . get_permalink() . '" 

            rel="nofollow" target="_blank" class="com-comparison-submit__button" 
            title="' . get_the_title() . '">' .  __($this->comparison_metabox['select_btn_text'], "comporisons") . ' ' . get_the_title() . '</a>';
        }
        return $html .= '</div></div><div class="com-comparison__more">
        <div class="com-comparison-submit__terms" data-toggle-id="com-comparison-terms-1">' . __($this->comparison_metabox['text_label_term_condition'], "comporisons") . '</div>
            </div>';
    }
    private function get_html_submit_block_v2($buttons_text)
    {
        $html = ' <td class="column cbl-button">';
        if (!empty($this->comparison_metabox['select_btn_link'])) {
            $html .= '<a ' . (isset($this->comparison_metabox['select_btn_color']) ? ('style="background-color:' . $this->comparison_metabox['select_btn_color'] . '"') : '') .
                'href = "' . get_permalink() . '" 
            rel="nofollow" target="_blank" class="comparison-bonus-list-submit__button" 
            title="' . (!empty($buttons_text) ? $buttons_text  : get_the_title()) . '">' . (!empty($buttons_text) ? ''  : __($this->comparison_metabox['select_btn_text'], "comporisons")) . ' ' . (!empty($buttons_text) ? $buttons_text  : get_the_title()) . '</a>';
        }


        if (!empty($this->comparison_metabox['logo_brand_label'])) {
            $html .= '<div class="comparison-bonus-list-brand-label">';
            if (!empty($this->comparison_metabox['logo_brand_label_link'])) {
                $html .= '<a style="color:' .
                    $this->comparison_metabox['logo_brand_label_color'] . '" href="' .
                    $this->comparison_metabox['logo_brand_label_link']
                    . '" rel="nofollow" target="_blank" title="' .
                    $this->comparison_metabox['logo_brand_label'] . '">' . $this->comparison_metabox['logo_brand_label'] . '</a>';
            } else {
                $html .= '<span style="color:' .
                    $this->comparison_metabox['logo_brand_label_color'] . '">' . $this->comparison_metabox['logo_brand_label'] . '</span>';
            }
            $html .= '</div>';
        }


        return  $html;
    }

    /** render html terms block */
    private function get_html_terms_block()
    {
        $html = '<div class="com-comparison-terms-wrap hidden-terms" id="com-comparison-terms-1">
                <dl class="com-comparison-terms__list">';
        if (is_array($this->comparison_metabox['more_info'])) {
            foreach ($this->comparison_metabox['more_info'] as $value) {
                if (!empty($value['link_title'])) {
                    $html .= '<dt>' . $value['link_title'] . ':</dt>
                        <dd class="terms-list__' . $value['icon'] . '">
                        ' . $value['description'] . '
                        </dd>';
                }
            }
        }
        return $html .= '</dl></div>';
    }

    /** render html Other Links block */
    private function get_html_other_links()
    {
        $simbol = ' | ';
        if (array_key_exists('other_links', $this->comparison_metabox) && is_array($this->comparison_metabox['other_links'])) {
            $html = '<div class="com-comparison-promote__links' . (defined('JSON_REQUEST') ? ' com-animated' : '') . '">';
            foreach ($this->comparison_metabox['other_links'] as $key => $value) {
                if ($key == array_key_last($this->comparison_metabox['other_links'])) {
                    $simbol = '';
                }

                if ($value['other_links_title']) {
                    if (!empty($value['other_link'])) {
                        $html .= '<span>
                        <a href="' . $value['other_link'] . '" rel="nofollow noopener" target="_blank" title="' . $value['other_links_title'] . '">
                        ' . $value['other_links_title'] . '</a>
                        </span>' . $simbol;
                    } else {
                        $html .= '<span title="' . $value['other_links_title'] . '">'
                            . $value['other_links_title'] .
                            '</span>' . $simbol;
                    }
                }
            }
            return $html .= '</div>';
        }

        return '<div class="com-comparison-promote__links"></div>';
    }

    /** render html Other Links block */
    private function get_html_top_bar_info($comparison_list_metabox)
    {
        $simbol = ' | ';
        if (array_key_exists('top_bar_info', $comparison_list_metabox) && is_array($comparison_list_metabox['top_bar_info'])) {
            $html = '<td class="cbl-top-bar' . (defined('JSON_REQUEST') ? ' com-animated' : '') . '">';
            foreach ($comparison_list_metabox['top_bar_info'] as $key => $value) {
                if ($key == array_key_last($comparison_list_metabox['top_bar_info'])) {
                    $simbol = '';
                }

                if ($value['top_bar_title']) {
                    if (!empty($value['top_bar_link'])) {
                        $html .= '<span>
                        <a href="' . $value['top_bar_link'] . '" rel="nofollow noopener" target="_blank" title="' . $value['top_bar_title'] . '" ' . (!empty($value['top_bar_link_color']) ? 'style="color:' . $value['top_bar_link_color'] . '!important;"' : '') . '>' . $value['top_bar_title'] . '</a>
                        </span>' . $simbol;
                    } else {
                        $html .= '<span title="' . $value['top_bar_title'] . '" ' . (!empty($value['top_bar_link_color']) ? 'style="color:' . $value['top_bar_link_color'] . '!important;"' : '') . '>'
                            . $value['top_bar_title'] .
                            '</span>' . $simbol;
                    }
                }
            }

            $html .= '
            <style>.cbl-top-bar, .cbl-top-bar *{' .
                (!empty($comparison_list_metabox['top_bar_title_color']) ? 'color:' . $comparison_list_metabox['top_bar_title_color'] . '!important;' : '') .
                (!empty($comparison_list_metabox['top_bar_bg_title_color']) ? 'background-color:' . $comparison_list_metabox['top_bar_bg_title_color'] . '!important;' : '') .
                (!empty($comparison_list_metabox['top_bar_font_weight']) ? 'font-weight:' . $comparison_list_metabox['top_bar_font_weight'] . '!important;' : '') .
                (!empty($comparison_list_metabox['top_bar_font_size']) ? 'font-size:' . $comparison_list_metabox['top_bar_font_size'] . '!important;' : '') .
                '@media (max-width: 768px){' .
                (!empty($comparison_list_metabox['top_bar_mobile_font_size']) ? 'font-size:' . $comparison_list_metabox['top_bar_mobile_font_size'] . '!important;' : '');
            $html .= '}}
            </style></th>';















            return $html .= '</td>';
        }

        return '<td class="com-comparison-promote__links"></td>';
    }

    /**
     *  get comparison metabox value
     */
    public function getMetabox($metabox_id, $default = '')
    {
        return $this->comparison_metabox[$metabox_id] ?? $default;
    }

    /**
     * transform post metabox to array
     */
    public function metabox_transform_to_array($id)
    {
        $metabox_field = Comparison_Metabox::get_metaboxes();
        $metabox_array = [];

        $comparison_metabox = get_post_meta($id, '', true);

        foreach ($metabox_field[0]['metadata'] as $key => $field) {

            if (
                isset($comparison_metabox[$this->comparison . '_metadata_' . $field['slug']]) &&
                is_array($comparison_metabox[$this->comparison . '_metadata_' . $field['slug']])
            ) {

                if ($field['type'] === 'repeater') {
                    $data = unserialize(unserialize($comparison_metabox[$this->comparison . '_metadata_' . $field['slug']][0]));

                    foreach ($data as $key => $repeater_field) {
                        foreach ($field['fields'] as $field_key => $value) {
                            $slug = 'repeater_' . $field['slug'] . '_field_' . $field['fields'][$field_key]['slug'];
                            $metabox_array[$field['slug']][$key][$field['fields'][$field_key]['slug']] =  $repeater_field[$slug]['data'];
                        }
                    }
                    continue;
                }
                $metabox_array[$field['slug']] = $comparison_metabox[$this->comparison . '_metadata_' . $field['slug']][0];
            }
        }

        return $metabox_array;
    }

    public static function metabox_list_transform_to_array($id)
    {
        $metabox_field = Comparison_List_Metabox::get_list_metaboxes();
        $metabox_array = [];



        $comparison_list_metabox = get_post_meta($id, '', true);


        foreach ($metabox_field[0]['metadata'] as $key => $field) {

            if (
                isset($comparison_list_metabox['com_comporison_list_metadata_' . $field['slug']]) &&
                is_array($comparison_list_metabox['com_comporison_list_metadata_' . $field['slug']])
            ) {

                if ($field['type'] === 'repeater') {
                    $data = unserialize(unserialize($comparison_list_metabox['com_comporison_list_metadata_' . $field['slug']][0]));

                    foreach ($data as $key => $repeater_field) {
                        foreach ($field['fields'] as $field_key => $value) {
                            $slug = 'repeater_' . $field['slug'] . '_field_' . $field['fields'][$field_key]['slug'];
                            $metabox_array[$field['slug']][$key][$field['fields'][$field_key]['slug']] =  $repeater_field[$slug]['data'];
                        }
                    }
                    continue;
                }
                $metabox_array[$field['slug']] = $comparison_list_metabox['com_comporison_list_metadata_' . $field['slug']][0];
            }
        }

        return $metabox_array;
    }

    /**
     * Converting px to em
     */
    public function convertPxToEm($px = 16)
    {
        return $px / 16;
    }
}
