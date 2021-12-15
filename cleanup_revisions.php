<?php
/**
 * Small action hook to keep a number of revisions but remove runduant thereafter
 *
 * @return void
 */
function cleanup_revisions_callback() {
	$revisions_to_keep = 10; // number of revisions to keep
	error_log('Clean up started: ' . date('Y-m-d h:i:s'));
	$args = array(
		'post_type' => 'any',
		'posts_per_page' => '-1',
		'post_status' => 'publish'
	);
	$posts = get_posts($args);
	error_log(count($posts) . ' posts found');
	foreach ($posts as $post) {
		$args = array(
			'post_type' => 'revision',
			'post_parent' => $post->ID,
			'posts_per_page' => '-1',
			'post_status' => 'inherit',
		);
		$revisions = get_posts($args);
		error_log(count($revisions) . ' revisions found for ' . $post->ID);

		$i = 1;
		foreach ($revisions as $revision) {
			if($i <= $revisions_to_keep) { 
				$i++;
				continue;
			} else {
				error_log('Cleaning up revision ' . $revision->ID . ' starting at revision no: ' . $i);
				wp_delete_post( $revision->ID, true );
				$i++;
			}
			
		}
	}
}
add_action('cleanup_revisions', 'cleanup_revisions_callback');