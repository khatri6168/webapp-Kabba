<?php

use Botble\Widget\AbstractWidget;

class CallToActionWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Call To Action'),
            'description' => __('Call to action widget.'),
        ]);
    }
}
