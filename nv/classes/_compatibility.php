<?php
/**
 * Items here will be loaded in the global scope before the core NV() class. This is meant to provide convenient
 * fallback support for integration with other tools & plugins.
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