<?php

use Botble\Widget\AbstractWidget;

class ContactInformation extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Contact information'),
            'description' => __('Widget display Contact information'),
            'title' => __('Contact information'),
            'phone' => '',
            'email' => '',
            'address' => '',
            'working_hours_start' => '',
            'working_hours_end' => '',
        ]);
    }
}
