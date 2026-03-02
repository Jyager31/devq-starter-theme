<?php

// Name
function name()
{
    return esc_html(get_field('branding_company_name', 'option'));
}
add_shortcode('name', 'name');


// Phone
function phone()
{
    return esc_html(get_field('contact_phone', 'option'));
}
add_shortcode('phone', 'phone');


// Email
function email()
{
    return esc_html(get_field('contact_email', 'option'));
}
add_shortcode('email', 'email');

//Address
function address()
{
    return esc_html(get_field('contact_address', 'option'));
}

add_shortcode('address', 'address');
