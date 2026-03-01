<?php

// Disable all WordPress update emails
add_filter('auto_core_update_send_email', 'disable_update_emails', 10, 4);

function disable_update_emails($send, $type, $core_update, $result)
{
    if ($type == 'success' || $type == 'fail') {
        return false;
    }
    return $send;
}
