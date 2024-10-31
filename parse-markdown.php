<?php
/**
 * Parse Markdown Plugin
 *
 * @package ParseMarkdown
 *
 * Plugin Name: Parse Markdown
 * Description: Integrate Markdown into your WordPress site. A simple, light-weight, no configuration-required, standards-driven plugin that allows commenters to use Markdown in their comments.
 * Plugin URI:  https://www.benmarshall.me/wordpress-markdown/
 * Version:     1.0.1
 * Author:      Ben Marshall
 * Author URI:  https://www.benmarshall.me
 * Text Domain: parse-markdown
 */

define( 'PARSE_MARKDOWN', __FILE__ );

/**
 * Include required dependencies.
 */
require plugin_dir_path( PARSE_MARKDOWN ) . 'vendor/autoload.php';

/**
 * Parse comment text.
 *
 * @since 1.0.0
 *
 * @param string          $comment_text Text of the current comment.
 * @param WP_Comment|null $comment The comment object. Null if not found.
 * @return string The parsed comment.
 */
function parse_markdown_comment_text( $comment_text, $comment = null ) {
	return parse_markdown(
		$comment_text,
		array(
			'inline' => true,
		)
	);
}
add_filter( 'comment_text', 'parse_markdown_comment_text', 10, 2 );

/**
 * Parse Markdown content.
 *
 * @since 1.0.1
 *
 * @param string $string String to parse.
 * @param array  $args Markdown parsing arguments.
 * @return string The parsed string.
 */
function parse_markdown( $string, $args = array() ) {
	$parsedown = new Parsedown();

	if ( isset( $args['safe_mode'] ) ) {
		$parsedown->setSafeMode( $args['safe_mode'] );
	} else {
		$parsedown->setSafeMode( true );
	}

	if ( ! empty( $args['escaped'] ) ) {
		$parsedown->setMarkupEscaped( true );
	}

	if ( ! empty( $args['inline'] ) ) {
		return $parsedown->line( $string );
	}

	return $parsedown->text( $string );
}
