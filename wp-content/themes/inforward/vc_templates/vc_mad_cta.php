<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->buildTemplate( $atts, $content );
$containerClass = trim( 'cp-call-out call-out ' . esc_attr( implode( ' ', $this->getTemplateVariable( 'container-class' ) ) ) );
$columnLeftClasses = esc_attr( implode( ' ', $this->getTemplateVariable( 'column-left-class' ) ) );
$columnRightClasses = esc_attr( implode( ' ', $this->getTemplateVariable( 'column-right-class' ) ) );
?>
<div class="<?php echo esc_attr( $containerClass ); ?>">
	<div class="cp-t-row">

		<?php if ( !empty($columnLeftClasses) ): ?><div class="<?php echo esc_attr($columnLeftClasses)  ?>"><?php endif; ?>

			<?php echo wp_kses_post($this->getTemplateVariable( 'heading' )); ?>
			<?php echo wp_kses_post($this->getTemplateVariable( 'subheading' )); ?>

		<?php if ( !empty($columnLeftClasses) ): ?></div><?php endif; ?>

		<div class="<?php echo esc_attr($columnRightClasses)  ?>">

			<?php echo wp_kses_post($this->getTemplateVariable( 'cp-actions-form' )); ?>
			<?php echo wp_kses_post($this->getTemplateVariable( 'cp-actions-button' )); ?>

		</div>

	</div>
</div>