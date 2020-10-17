<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/organizer.php
 *
 * @package TribeEventsCalendar
 * @version 4.4
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h6 class="event-detail-title"><?php echo tribe_get_organizer_label( ! $multiple ); ?></h6>
	<ul  class="event-detail-list">
		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;
			}

			?>
            <li class="flex-row flex-justify">
                <div class="detail-col"><?php echo esc_html__('Organizer Name:','inforward') ?></div>
                <div class="detail-col tribe-organizer">
                    <?php echo tribe_get_organizer_link( $organizer ) ?>
                </div>
             </li>
			<?php
		}

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
                <li class="flex-row flex-justify">
                    <div class="detail-col">
                        <?php esc_html_e( 'Phone:', 'inforward' ) ?>
                    </div>
                    <div class="detail-col tribe-organizer-tel">
                        <?php echo esc_html( $phone ); ?>
                    </div>
                </li>
				<?php
			}//end if

			if ( ! empty( $email ) ) {
				?>
                <li class="flex-row flex-justify">
                    <div class="detail-col">
                        <?php esc_html_e( 'Email:', 'inforward' ) ?>
                    </div>
                    <div class="detail-col tribe-organizer-email">
					<a href="maito:<?php echo antispambot($email, 1) ?>"><?php echo esc_html( $email ); ?></a>
                        
                    </div>
                </li>
				<?php
			}//end if

			if ( ! empty( $website ) ) {
				?>
                <li class="flex-row flex-justify">
                    <div class="detail-col">
                        <?php esc_html_e( 'Website:', 'inforward' ) ?>
                    </div>
                    <div class="detail-col tribe-organizer-url">
                        <?php echo wp_kses_post($website); ?>
                    </div>
                </li>
				<?php
			}//end if
		}//end if

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>
	</ul>
</div>
