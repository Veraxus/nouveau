<?php
/** The \NV\Theme\Customize\WalkerComments class */

namespace NV\Theme\Customize;

use NV\Theme\Core;

/**
 * This is our custom comment walker. Since comments can have complex parent-child relationships, we utilize Walker to
 * handle output instead of a more traditional loop.
 *
 * @package NV\Custom
 */
class WalkerComments extends \Walker {

	/**
	 * What element tag to use for level separators?
	 * @var string
	 */
	var $lvl_elem = 'section';

	/**
	 * Specifies the tree type we are handling.
	 * @var string
	 */
	var $tree_type = 'comment';


	/**
	 * Required by the Walker to track items in the tree
	 * @var array
	 */
	var $db_fields = [
		'parent' => 'comment_parent',
		'id'     => 'comment_ID'
	];


	/**
	 * This runs each time we reach the start of a new "branch" (any comment with replies).
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of comment.
	 * @param array  $args   Uses 'style' argument for type of HTML list.
	 */
	function start_lvl( &$output, $depth = 0, $args = [] ) {

		// Increment the current comment_depth count
		$GLOBALS['comment_depth'] = $depth + 1;

		// We want to output an OPENING <ol> tag
		printf( '<%s class="replies">' . "\n", $this->lvl_elem );
	}


	/**
	 * This runs each time we reach the end of a "branch" (any string of comments or replies)
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of comment.
	 * @param array  $args   Will only append content if style argument value is 'ol' or 'ul'.
	 */
	function end_lvl( &$output, $depth = 0, $args = [] ) {

		// Increment the current comment_depth count
		$GLOBALS['comment_depth'] = $depth + 1;

		// We want to output a CLOSING </ol> tag
		printf( '</%s>' . "\n", $this->lvl_elem );
	}


	/**
	 * This modifies the default display_element() function to "flatten" any replies that exceed the max_depth.
	 *
	 * This function is taken from the Walker_Comment class in WordPress core.
	 *
	 * @see Walker::display_element()
	 *
	 * @param object $element           Data object.
	 * @param array  $children_elements List of elements to continue traversing.
	 * @param int    $max_depth         Max depth to traverse.
	 * @param int    $depth             Depth of current element.
	 * @param array  $args              An array of arguments. @see wp_list_comments()
	 * @param string $output            Passed by reference. Used to append additional content.
	 *
	 * @return null Null on failure with no changes to parameters.
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		// Do nothing if $element is false...
		if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];
		$id       = $element->$id_field;

		// Run the standard display_element() function now...
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		// If we're at the max depth, and the current element still has children, loop over those and display them at
		// this level. This is to prevent them being orphaned to the end of the comment list.
		if ( $max_depth <= $depth + 1 && isset( $children_elements[$id] ) ) {

			foreach ( $children_elements[$id] as $child ) {
				$this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
			}

			unset( $children_elements[$id] );
		}

	}


	/**
	 * Start output for an individual comment.
	 *
	 * @param string $output  Passed by reference. Used to append additional content.
	 * @param object $comment Comment data object.
	 * @param int    $depth   Depth of comment in reference to parents.
	 * @param array  $args    An array of arguments. @see wp_list_comments()
	 * @param int    $id
	 */
	function start_el( &$output, $comment, $depth = 0, $args = [], $id = 0 ) {

		// Keep track of current depth and comment
		$depth ++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment']       = $comment;

		// If a callback is provided, run it now...
		if ( ! empty( $args['callback'] ) ) {
			call_user_func( $args['callback'], $comment, $args, $depth );

			return;
		}

		// If this is a pingback (of any kind), load pingback template, otherwise use the standard comment template...
		if ( ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping'] ) {
			require Core::i()->paths->parts . 'comments/pingback.php';
		} else {
			require Core::i()->paths->parts . 'comments/single.php';
		}
	}


	/**
	 * Allows plugins and such to output content after the end element.
	 *
	 * @see Walker::end_el()
	 *
	 * @param string $output  Passed by reference. Used to append additional content.
	 * @param object $comment The comment object. Default current comment.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments. @see wp_list_comments()
	 */
	function end_el( &$output, $comment, $depth = 0, $args = [] ) {

		// If a callback is provided in the arguments, we need to run it...
		if ( ! empty( $args['end-callback'] ) ) {
			call_user_func( $args['end-callback'], $comment, $args, $depth );

			return;
		}

	}

}