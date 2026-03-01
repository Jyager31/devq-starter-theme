<?php

// Name
function name()
{
    return esc_html(get_field('name', 'option'));
}
add_shortcode('name', 'name');


// Phone
function phone()
{
    return esc_html(get_field('phone', 'option'));
}
add_shortcode('phone', 'phone');


// Email
function email()
{
    return esc_html(get_field('email', 'option'));
}
add_shortcode('email', 'email');

//Address
function address()
{
    $address = get_field('address_1', 'option');
    $city_state_zip = get_field('city_state_zip_1', 'option');

    return esc_html($address . ', ' . $city_state_zip);
}

add_shortcode('address', 'address');
