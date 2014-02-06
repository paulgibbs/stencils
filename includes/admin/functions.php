<?php
/**
 * Admin functions
 *
 * @package Stencils
 * @subpackage AdminFunctions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * When a post is saved, maybe generate a stencil template.
 *
 * @param int $post_id
 */
function dks_maybe_generate_stencil( $post_id ) {

	// Bail if doing an autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	// Bail if not a post request
	if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return $post_id;

	// Bail if not saving a Stencils-supported post type
	if ( ! in_array( get_post_type( $post_id ), dks_get_stencils_post_types() ) )
		return $post_id;

	// Bail if current user cannot edit this post
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// Bail if the user doesn't want this to be a stencils post
	// DJPAULTODO: this assume post meta is set *before* we get here. We might need to revisit this assumption ;)
	if ( ! dks_is_stencils_post( $post_id ) )
		return;

	dks_generate_stencil( $post_id );
}

// http://dracoblue.net/dev/gotchas-when-parsing-xml-html-with-php/
// This assumes post_content is definitely UTF-8
function dks_generate_stencil( $post_id ) {

	$post = get_post( $post_id );
	if ( ! $post )
		return;

	// Get the post's rendered HTML content.
	$html = apply_filters( 'the_content', $post->post_content );
	$html = str_replace( ']]>', ']]&gt;', $html );

	// Strips out vertical tabs and other special UTF-8 characters to avoid errors like "non SGML character number 11".
	$html = preg_replace('/[\x1-\x8\xB-\xC\xE-\x1F]/', '', $html );

	// Make $html a complete, valid HTML document.
	$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=' . esc_attr( get_option(' blog_charset' ) ) . '"/></head><body>' . $html . '</body></html>';

	/**
	 * Try to load the $html into a DOMDocument for parsing.
	 *
	 * We turn off libxml errors to prevent PHP throwning Notices if any problems occur when parsing the string.
	 */
	$node = new DOMDocument( '1.0', 'utf-8' );

	libxml_use_internal_errors( true );
	$node->loadHTML( $html );
	$error = libxml_get_last_error();
	libxml_use_internal_errors( false );

	if ( $error ) {
		error_log( 'stencilstodo xml parsing problem: ' . print_r( $error, true ) );
		error_log( $html );
		return;
	} 

	$data = convertDomNodeToDataArray($node);

	// Since we faked a complete HTML document from the post_content, only the <body> part is useful.
	$data = $data['html']['body'];	

	echo '<pre>';
	die(var_dump($node));
}

function convertDomNodeToDataArray(DomNode $node)
    {
        $data = array();
        $values = array();
        $has_value = false;

        if ($node->hasChildNodes())
        {
            foreach ($node->childNodes as $child_node)
            {
                /*
                 * A html dom node always contains one dom document type child
                 * node with no content (DOMDocumentType#internalSubset is for
                 * example <!DOCTYPE html>). Ignore it!
                 */
                if ($child_node instanceof DOMDocumentType)
                {
                    continue ;
                }
                
                if ($child_node->nodeType === XML_TEXT_NODE)
                {
                    $has_value = true;
                    $values[] = $child_node->nodeValue;
                }
                else
                {
                    $key = $child_node->nodeName;

                    if (isset($data[$key]))
                    {
                        if (!is_array($data[$key]) || !isset($data[$key][0]))
                        {
                            $data[$key] = array($data[$key]);
                        }
                        $data[$key][] = convertDomNodeToDataArray($child_node);
                    }
                    else
                    {
                        $data[$key] = convertDomNodeToDataArray($child_node);
                    }
                }
            }
        }

        if ($node->hasAttributes())
        {
            foreach ($node->attributes as $attribute_node)
            {
                $key = '@' . $attribute_node->nodeName;
                $data[$key] = $attribute_node->nodeValue;
            }
        }

        if ($has_value)
        {
            $value = implode('', $values);

            if (trim($value) != '')
            {
                if (empty($data))
                {
                    $data = $value;
                }
                else
                {
                    $data['@'] = $value;
                }
            }
        }
        
        return $data;
    }