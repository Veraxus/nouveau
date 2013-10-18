<?php
/**
 * Items in this file are deliberately loaded in the global scope and should NOT be encapsulated in a class.
 * 
 * This file is meant to override WordPress's pluggable functions. ONLY functions that are explicitly overriding
 * WordPress pluggable functions should be placed here.
 * 
 * If there is a need for any additional global functions, please place them in the _global.php file.
 * 
 * @package WordPress
 * @subpackage Nouveau
 * @since Nouveau 1.0
 */


/**
 * Ensure that dbgx_trace_var() is defined... just in case it's left in after disabling Debug Bar Extender.
 *
 * Note that this check works because plugins are loaded BEFORE the theme by default.
 *
 * @see http://codex.wordpress.org/Plugin_API/Action_Reference
 */
if ( ! function_exists('dbgx_trace_var') ) {
    function dbgx_trace_var() {
        return;
    }
}