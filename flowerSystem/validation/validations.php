<?php

function sanitize_data($data = ''){

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;

}

function validate_required_data($data = ''){

    $data = sanitize_data($data);

    if( !empty($data) )
    {
        return $data;
    }

    return FALSE;

}

?>