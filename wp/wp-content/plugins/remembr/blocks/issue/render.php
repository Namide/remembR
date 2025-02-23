<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$blocks = parse_blocks(get_post()->post_content);
$remember_issue_blocks = array_filter($blocks, function($obj) {
	return $obj['blockName'] == 'remembr/issue';
});
$last_block_index = array_search('remembr/issue', array_reverse(array_column($blocks, 'blockName'), true));
$last_block = $blocks[$last_block_index];
$is_current_block_last =
	$last_block['attrs']['question'] == $attributes['question'] &&
	$last_block['attrs']['response'] == $attributes['response'];
?>

<!-- <?= var_dump($attributes['list']) ?> -->
<!-- <?= var_dump($content) ?> -->
<!-- <?= var_dump($block->parsed_block) ?> -->
<!-- <?= var_dump(parse_blocks(get_post()->post_content)) ?> -->

<?php

// Get last 'remembr/issue' block and display only it
if ($is_current_block_last) {
	
	// If user submit, add all questions
	if (isset($_POST['done']) && isset($_POST['postID'])) {
		foreach ($remember_issue_blocks as $issue_block) {
			$question = $issue_block['attrs']['question'];
			$response = $issue_block['attrs']['response'];

			// todo: 
			// 1. search questions in DB
			// 2. add questions in DB table (or get questions ID)
			// 3. add user spaced repetition to DB table
		}
	}
	?>

	<form action="" method="post" <?= get_block_wrapper_attributes(); ?>>
		<input type="hidden" name='done' value="1" >
		<input type="hidden" name='postID' value="<?= get_the_ID() ?>" >
		<input type="submit" value="<?= esc_html_e( 'I learned this card', 'issue' ); ?>">
	</form>

<?php } ?>


