<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<form <?= get_block_wrapper_attributes(); ?>>
	<input type="submit" value="<?= esc_html_e( 'I learned this card', 'issue' ); ?>">
</form>
