<?php

/**
 * Handles AJAX calls to get a post title by its ID.
 * 
 * @since m2m
 */
class Toolset_Ajax_Handler_Get_Post_By_Id extends Toolset_Ajax_Handler_Abstract {


	/**
	 * @param array $arguments Original action arguments.
	 *
	 * @return void
	 */
	function process_call( $arguments ) {

		$this->ajax_begin(
			array(
				'nonce' => Toolset_Ajax::CALLBACK_GET_POST_BY_ID,
				'is_public' => true
			)
		);
		
		// Read and validate input
		$s = toolset_getpost( 's' );
		
		
		if ( empty( $s ) ) {
			$this->ajax_finish( array( 'message' => __( 'Wrong or missing query.', 'wpv-views' ) ), false );
		}
		
		global $wpdb;
		
		$result = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT post_title 
				FROM {$wpdb->posts} 
				WHERE ID = %d 
				LIMIT 1",
				$s
			)
		);
		
		if ( isset( $result ) ) {
			$output = array( 'label' => $result );
			$this->ajax_finish( $output, true );
		}
		
		$this->ajax_finish( array( 'message' => __( 'Error while retrieving result.', 'wpv-views' ) ), false );
		
	}

}