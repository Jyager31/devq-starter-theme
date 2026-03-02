<?php
/**
 * Animation Helper Functions
 */

/**
 * Generate AOS data attributes string.
 *
 * @param string   $type     AOS animation type (e.g., 'fade-up', 'fade-left').
 * @param int      $delay    Delay in milliseconds.
 * @param int|null $duration Duration in ms. Omitted if null or 800 (AOS default).
 * @return string  HTML attribute string.
 */
function devq_aos($type, $delay = 0, $duration = null) {
    $attrs = 'data-aos="' . esc_attr($type) . '"';
    if ($delay > 0) {
        $attrs .= ' data-aos-delay="' . esc_attr($delay) . '"';
    }
    if ($duration && $duration != 800) {
        $attrs .= ' data-aos-duration="' . esc_attr($duration) . '"';
    }
    return $attrs;
}
