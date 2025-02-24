<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

require_once REMEMBR__PLUGIN_DIR . 'blocks/issue/class.issue.php';

// var_dump($attributes['list']);
// var_dump($content);
// var_dump($block->parsed_block);
// var_dump(parse_blocks(get_post()->post_content));

$remembr_issue = new Remembr_Issue();

// Is not a post (don't display)
if ($remembr_issue->is_post == false) { ?>

	<!-- Questions/responses hidden -->

<?php // Disable all calculation if is it not the last block 
} else if ($remembr_issue->get_is_last_issue_block($attributes) == false) { ?>

	<!-- Hide this question -->

<?php // User not connected
} else if ($remembr_issue->is_user_connected == false) { ?>

	<p <?= get_block_wrapper_attributes(['class' => 'wp-block-remembr-issue--warning']); ?>>⚠️ <?= __('To use the learning system, you must be logged in.', 'RemembR'); ?></p>

<?php // Already learning 
} elseif ($remembr_issue->get_is_learning()) {
	$progress = $remembr_issue->get_learning_progress();
?>

	<p <?= get_block_wrapper_attributes(['class' => 'wp-block-remembr-issue--message']); ?>>📈 <?= __('Already learning', 'RemembR'); ?> <?= round($progress * 100) ?>% </p>

<?php // If user submit, save all questions (only for the last render.php call)
} else if ($remembr_issue->get_is_user_submitting()) {
	$count = $remembr_issue->user_submit();
?>

	<p <?= get_block_wrapper_attributes(['class' => 'wp-block-remembr-issue--message']); ?>>✅ <?= sprintf(__('You\'ve just added %d questions to your list', 'RemembR'), $count); ?></p>

<?php // Display the leaned CTA (only for the last render.php call)
} else if ($remembr_issue->get_is_user_submitting() == false) {
?>

	<form action="" method="post" <?= get_block_wrapper_attributes(); ?>>
		<input type="hidden" name='done' value="1">
		<input type="hidden" name='postID' value="<?= get_the_ID() ?>">
		<input type="submit" value="<?= esc_html_e('Card learned', 'RemembR'); ?> 👍" class="wp-block-remembr-issue--cta">
	</form>

<?php } ?>