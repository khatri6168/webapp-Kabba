<?php

return [
    'settings' => 'Settings',
    'name' => 'Ecommerce',
    'setting' => [
        'email' => [
            'title' => 'E-commerce',
            'description' => 'Ecommerce email config',
            'order_confirm_subject' => 'Subject of order confirmation email',
            'order_confirm_subject_placeholder' => 'The subject of email confirmation send to the customer',
            'order_confirm_content' => 'Content of order confirmation email',
            'order_status_change_subject' => 'Subject of email when changing order\'s status',
            'order_status_change_subject_placeholder' => 'Subject of email when changing order\'s status send to customer',
            'order_status_change_content' => 'Content of email when changing order\'s status',
            'from_email' => 'Email from',
            'from_email_placeholder' => 'Email from address to display in mail. Ex: example@gmail.com',
        ],
        'title' => 'Basic information',
        'state' => 'State',
        'city' => 'City',
        'country' => 'Country',
        'weight_unit_gram' => 'Gram (g)',
        'weight_unit_kilogram' => 'Kilogram (kg)',
        'weight_unit_lb' => 'Pound (lb)',
        'weight_unit_oz' => 'Ounce (oz)',
        'height_unit_cm' => 'Centimeter (cm)',
        'height_unit_m' => 'Meter (m)',
        'height_unit_inch' => 'Inch',
        'store_locator_title' => 'Store locators',
        'store_locator_description' => 'All the lists of your chains, main stores, branches, etc. The locations can be used to track sales and to help us configure tax rates to charge when selling products.',
        'phone' => 'Phone',
        'email_address' => 'Email',
        'address' => 'Address',
        'is_primary' => 'Primary?',
        'add_new' => 'Add new',
        'or' => 'Or',
        'change_primary_store' => 'change default store locator',
        'other_settings' => 'Other settings',
        'other_settings_description' => 'Settings for cart, review...',
        'enable_cart' => 'Enable shopping cart?',
        'enable_tax' => 'Enable tax?',
        'display_product_price_including_taxes' => 'Display product price including taxes?',
        'enable_review' => 'Enable review?',
        'enable_quick_buy_button' => 'Enable quick buy button?',
        'quick_buy_target' => 'Quick buy target page?',
        'checkout_page' => 'Checkout page',
        'cart_page' => 'Cart page',
        'add_location' => 'Add location',
        'edit_location' => 'Edit location',
        'delete_location' => 'Delete location',
        'change_primary_location' => 'Change primary location',
        'delete_location_confirmation' => 'Are you sure you want to delete this location? This action cannot be undo.',
        'save_location' => 'Save location',
        'accept' => 'Accept',
        'select_country' => 'Select country...',
        'zip_code_enabled' => 'Enable Zip Code?',
        'thousands_separator' => 'Thousands separator',
        'decimal_separator' => 'Decimal separator',
        'separator_period' => 'Period (.)',
        'separator_comma' => 'Comma (,)',
        'separator_space' => 'Space ( )',
        'available_countries' => 'Available countries',
        'all' => 'All',
        'verify_customer_email' => "Verify customer's email?",
        'minimum_order_amount' => 'Minimum order amount to place an order (:currency).',
        'enable_guest_checkout' => 'Enable guest checkout?',
        'show_number_of_products' => 'Show number of products in the product single',
        'payment_method_cod_minimum_amount' => 'Minimum order amount - :currency (Optional)',
        'review' => [
            'max_file_size' => 'Review max file size (MB)',
            'max_file_number' => 'Review max file number',
        ],
        'using_custom_font_for_invoice' => 'Using custom font for invoice?',
        'invoice_font_family' => 'Invoice font family (Only work for Latin language)',
        'enable_invoice_stamp' => 'Enable invoice stamp?',
        'invoice_support_arabic_language' => 'Support Arabic language in invoice?',
        'disable_order_invoice_until_order_confirmed' => 'Disable order invoice until order confirmed?',
        'vat_number' => 'VAT number',
        'tax_id' => 'Tax ID',
        'enable_recaptcha_in_register_page' => 'Enable Recaptcha in the registration page?',
        'enable_math_captcha_in_register_page' => 'Enable Math captcha in the registration page?',
        'enable_recaptcha_in_register_page_description' => 'Need to setup Captcha in Admin -> Settings -> General first.',
        'show_out_of_stock_products' => 'Show out of stock products?',
        'default_tax_rate' => 'Default tax rate',
        'default_tax_rate_description' => 'Important: it will be applied if no tax selected in product.',
        'how_to_display_product_variation_images' => 'How to display product variation images?',
        'only_variation_images' => 'Only variation images',
        'variation_images_and_main_product_images' => 'Variation images + main product images',
        'load_countries_states_cities_from_location_plugin' => 'Load countries, states, cities from plugin location?',
        'load_countries_states_cities_from_location_plugin_placeholder' => 'After changing this option, you need to update all addresses again. You should set it once.',
        'enable_wishlist' => 'Enable wishlist?',
        'enable_compare' => 'Enable compare?',
        'enable_order_tracking' => 'Enable order tracking?',
        'recently_viewed' => [
            'enable' => 'Enable customer recently viewed products?',
            'max' => 'Maximum number of customer recently viewed products',
            'max_helper' => 'If you set 0, it will save all products.',
        ],
        'search_products' => 'Search products',
        'search_products_description' => 'Config rules to search products',
        'search_for_an_exact_phrase' => 'Search for an exact phrase?',
        'search_products_by' => 'Search products by:',
        'tracking_settings' => 'Tracking settings',
        'tracking_settings_description' => 'Manage tracking: UTM, Facebook, Google Tag Manager...',
        'enable_facebook_pixel' => 'Enable Facebook Pixel (Meta Pixel)?',
        'facebook_pixel_id' => 'Facebook Pixel ID',
        'facebook_pixel_helper' => 'Go to https://developers.facebook.com/docs/meta-pixel to create Facebook Pixel.',
        'enable_google_tag_manager' => 'Enable Google Tag Manager?',
        'google_tag_manager_code' => 'Google Tag Manager code',
        'google_tag_manager_helper' => 'Go to https://ads.google.com/aw/conversions to create Google Ads Conversions.',
        'webhook' => 'Webhook',
        'webhook_description' => 'Send webhook when order placed.',
        'shipping' => 'Shipping',
        'shipping_description' => 'Settings for shipping',
        'hide_other_shipping_options_if_it_has_free_shipping' => 'Hide other shipping options if it has free shipping in the list?',
        'order_placed_webhook_url' => 'Order placed webhook URL (method: POST)',
        'return_request' => 'Return Request',
        'return_request_description' => 'Number of days a customer can request a return after the order is completed.',
        'returnable_days' => 'Refundable days',
        'billing_address_enabled' => 'Enable billing address?',
        'activate_custom_return_product_quantity' => 'Activate custom return product quantity?',
        'allow_partial_return' => 'Allow partial return?',
        'allow_partial_return_description' => 'Customer can return a few products, do not need to return all products in an order.',
        'activate_custom_return_product_quantity_description' => 'Allow customer to change the quantity of the product they want to return.',
        'digital_product' => 'Digital product',
        'digital_product_title' => 'Is enabled to support the digital products?',
        'allow_guest_checkout_for_digital_products' => 'Allow guest checkout for digital products?',
        'company_settings' => 'Company settings',
        'company_settings_description' => 'Settings Company information for invoicing',
        'company_name' => 'Company name',
        'company_address' => 'Company address',
        'company_zipcode' => 'Company zipcode',
        'company_email' => 'Company email',
        'company_phone' => 'Company phone',
        'company_logo' => 'Company logo',
        'company_tax_id' => 'Company tax ID',
        'invoice_code_prefix' => 'Invoice code prefix',
        'only_allow_customers_purchased_to_review' => 'Only customers who have purchased the product can review the product?',
        'enable_order_auto_confirmed' => 'Auto confirm order?',
        'is_enabled_order_return' => 'Is enabled order return?',
        'is_enabled_product_options' => 'Is enabled product options?',
        'exchange_rate' => [
            'choose_api_provider' => 'Choose API provider',
            'select' => '-- Select --',
            'provider' => [
                'api_layer' => 'API Layer',
                'open_exchange_rate' => 'Open Exchange Rates',
            ],
            'open_exchange_app_id' => 'Open Exchange Rates App ID',
        ],
        'display_bank_info_at_the_checkout_success_page' => 'Display bank info at the checkout success page?',
        'mandatory_form_fields_at_checkout' => 'Mandatory fields at the checkout page:',
        'hide_form_fields_at_checkout' => 'Hide customer fields at checkout page:',
        'hours_allocated' => 'Hours Allocated',
        'hours_allocated_description' => '',
        'daily_hours' => 'Daily Hours',
        'weekend_hours' => 'Weekend Hours',
        'weekly_hours' => 'Weekly Hours',
        'monthly_hours' => 'Monthly Hours',
    ],
    'store_address' => 'Store address',
    'store_phone' => 'Store phone',
    'order_id' => 'Order ID',
    'order_token' => 'Order token',
    'customer_name' => 'Customer name',
    'customer_email' => 'Customer email',
    'customer_phone' => 'Customer phone',
    'customer_address' => 'Customer address',
    'product_list' => 'List products in order',
    'order_note' => 'Order note',
    'payment_detail' => 'Payment detail',
    'shipping_method' => 'Shipping method',
    'payment_method' => 'Payment method',
    'standard_and_format' => 'Standard & Format',
    'standard_and_format_description' => 'Standards and formats are used to calculate things like product prices, shipping weights, and order times.',
    'change_order_format' => 'Edit order code format (optional)',
    'change_order_format_description' => 'The default order code starts at: number. You can change the start or end string to create the order code you want, for example "DH-: number" or ": number-A"',
    'start_with' => 'Start with',
    'end_with' => 'End with',
    'order_will_be_shown' => 'Your order code will be shown',
    'weight_unit' => 'Unit of weight',
    'height_unit' => 'Unit length / height',
    'theme_options' => [
        'name' => 'Ecommerce',
        'description' => 'Theme options for Ecommerce',
        'number_products_per_page' => 'Number of products per page',
        'number_of_cross_sale_product' => 'Number of cross sale products in product detail page',
        'max_price_filter' => 'Maximum price to filter',
        'logo_in_the_checkout_page' => 'Logo in the checkout page (Default is the main logo)',
    ],
    'basic_settings' => 'Basic settings',
    'advanced_settings' => 'Advanced settings',
    'product_review_list' => 'Product review list',
    'less' => 'By providing your phone number and/or email, you agree to receive order information from us via text and/or email as well as other information pertaining to renting or buying equipment.',
    'more' => 'Standard text messaging rates may apply. Reply STOP to opt-out of receiving future text messages related to your order and / or rental equipment. You may unsubscribe from any email sent to you.',
    'learn_more' => 'Learn More',
    'learn_less' => 'Learn Less',
];
