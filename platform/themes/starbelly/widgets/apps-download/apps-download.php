<?php

use Botble\Widget\AbstractWidget;

class AppDownloadWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Apps download'),
            'description' => __('Apps download widget.'),
            'title' => '',
            'subtitle' => '',
            'image' => '',
            'platform_name_1' => '',
            'platform_button_image_1' => '',
            'platform_url_1' => '',
            'platform_name_2' => '',
            'platform_button_image_2' => '',
            'platform_url_2' => '',
            'platform_name_3' => '',
            'platform_button_image_3' => '',
            'platform_url_3' => '',
        ]);
    }
}
