<?php
/**
 * Common helper
 */

/************* CONSTANTS ********************/
define('CSS_URL', base_url() . 'public/css/');


/************* FLASH DATA ********************/
/**
 * Set flash data (add it into SESSION array)
 * @param string $item Flashdata name
 * @param mixed $value Flashdata value
 */
function set_flash($item, $value)
{
    $CI = &get_instance();
    $CI->session->set_userdata(array($item => $value));
}

/**
 * Render all flashes
 * @return mixed Flashdata value or FALSE if no such flashdata set
 */
function render_flashes()
{
    $CI = &get_instance();
    if ($success = $CI->session->userdata('success'))
    {
        echo '<div class="alert-success">'.$success.'</div>';
        $CI->session->unset_userdata('success');
    }
    
    if ($error = $CI->session->userdata('error'))
    {
        echo '<div class="alert-error">'.$error.'</div>';
        $CI->session->unset_userdata('error');
    }
    
    return;
}