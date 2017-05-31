<?php
/**
 * The template for displaying all single Event meta
 */
global $iee_events;

if( $event_id == '' ){
	$event_id = get_the_ID();
}

$start_date_str = get_post_meta( $event_id, 'start_ts', true );
$end_date_str = get_post_meta( $event_id, 'end_ts', true );
$start_date_formated = date_i18n( 'd F', $start_date_str );
$end_date_formated = date_i18n( 'd F', $end_date_str );
$start_time = date_i18n( 'H:i', $start_date_str );
$end_time = date_i18n( 'H:i', $end_date_str );
$website = get_post_meta( $event_id, 'iee_event_link', true );
?>
<div class="iee_event_meta">
<div class="iee_organizermain">
	<?php
  		// Organizer
		$org_name = get_post_meta( $event_id, 'organizer_name', true );
		$org_email = get_post_meta( $event_id, 'organizer_email', true );
		$org_phone = get_post_meta( $event_id, 'organizer_phone', true );
		$org_url = get_post_meta( $event_id, 'organizer_url', true );

		if( $org_name != '' ){
			?>
			<div class="organizer">
				<div class="titlemain"><?php esc_html_e( 'Les organisateurs','import-eventbrite-events' ); ?></div>
				<p><?php echo $org_name; ?></p>
			</div>
			<?php if( $website != '' ){ ?>
				<p>
					<strong><?php esc_html_e( 'Cliquez pour vous inscrire','import-eventbrite-events' ); ?>:<br>
						<span style="font-size:2em;"><a href="<?php echo esc_url( $website ); ?>"><?php echo $website; ?></a></span></strong>
			<?php } ?>
				</p>
			<?php if( $org_email != '' ){ ?>
		    	<strong><?php esc_html_e( 'Email','import-eventbrite-events' ); ?>:</strong>
		    	<a href="<?php echo 'mailto:'.$org_email; ?>"><?php echo $org_email; ?></a>
		    <?php } ?>
		    <?php if( $org_phone != '' ){ ?>
		    	<strong><?php esc_html_e( 'Téléphone','import-eventbrite-events' ); ?>:</strong>
		    	<a href="<?php echo 'tel:'.$org_phone; ?>"><?php echo $org_phone; ?></a>
		    <?php } ?>
		    <?php if( $website != '' ){ ?>
		    	<strong><?php esc_html_e( 'Site web','import-eventbrite-events' ); ?>:</strong>
		    	<a href="<?php echo esc_url( $org_url ); ?>"><?php echo $org_url; ?></a>
		    <?php }
		}
    ?>

  <div class="details">
    <div class="titlemain" > <?php esc_html_e( 'Details et inscriptions','import-eventbrite-events' ); ?> </div>

    <?php
    if( date( 'Y-m-d', $start_date_str ) == date( 'Y-m-d', $end_date_str ) ){
    	?>
    	<strong><?php esc_html_e( 'Date','import-eventbrite-events' ); ?>:</strong>
	    <p><?php echo $start_date_formated; ?></p>

	    <strong><?php esc_html_e( 'Time','import-eventbrite-events' ); ?>:</strong>
	    <p><?php echo $start_time . ' - ' . $end_time; ?></p>
		<?php
	}else{
		?>
		<p>
			<strong><span class="date"><?php esc_html_e( 'Début','import-eventbrite-events' ); ?>:</span></strong>
    	<?php echo $start_date_formated . ' - ' . $start_time; ?>
    	<strong><span class="date"><?php esc_html_e( 'Fin','import-eventbrite-events' ); ?>:</span></strong>
    	<?php echo $end_date_formated . ' - ' . $end_time; ?>
		</p>
		<?php
	}

	$eve_tags = $eve_cats = array();
	$event_categories = wp_get_post_terms( $event_id, $iee_events->cpt->get_event_categroy_taxonomy() );
	if( !empty( $event_categories ) ){
		foreach ($event_categories as $event_category ) {
			$eve_cats[] = '<a href="'. esc_url( get_term_link( $event_category->term_id ) ).'">' . $event_category->name. '</a>';
		}
	}

	$event_tags = wp_get_post_terms( $event_id, $iee_events->cpt->get_event_tag_taxonomy() );
	if( !empty( $event_tags ) ){
		foreach ($event_tags as $event_tag ) {
			$eve_tags[] = '<a href="'. esc_url( get_term_link( $event_tag->term_id ) ).'">' . $event_tag->name. '</a>';
		}
	}

	if( !empty( $eve_cats ) ){
		?>
		<strong><?php esc_html_e( 'Catégorie','import-eventbrite-events' ); ?>:</strong>
	    <p><?php echo implode(', ', $eve_cats ); ?></p>
		<?php
	}

	if( !empty( $eve_tags ) ){
		?>
		<strong><?php esc_html_e( 'Etiquettes','import-eventbrite-events' ); ?>:</strong>
	    <p><?php echo implode(', ', $eve_tags ); ?></p>
		<?php
	}
	?>
  </div>
	<div style="clear: both"></div>
</div>

<?php
$venue_name    = get_post_meta( $event_id, 'venue_name', true );
$venue_address = get_post_meta( $event_id, 'venue_address', true );
$venue['city'] = get_post_meta( $event_id, 'venue_city', true );
$venue['state'] = get_post_meta( $event_id, 'venue_state', true );
$venue['country'] = get_post_meta( $event_id, 'venue_country', true );
$venue['zipcode'] = get_post_meta( $event_id, 'venue_zipcode', true );
$venue['lat'] = get_post_meta( $event_id, 'venue_lat', true );
$venue['lon'] = get_post_meta( $event_id, 'venue_lon', true );
$venue_url = esc_url( get_post_meta( $event_id, 'venue_url', true ) );

if( $venue_name != '' && ( $venue_address != '' || $venue['city'] != '' ) ){
	?>
	<div class="iee_organizermain library">
		<div class="venue">
			<div class="titlemain"> <?php esc_html_e( 'Lieu partenaire','import-eventbrite-events' ); ?> </div>
			<p><?php echo $venue_name; ?></p>
			<?php
			if( $venue_address != '' ){
				echo '<p><i>' . $venue_address . '</i></p>';
			}
			$venue_array = array();
			foreach ($venue as $key => $value) {
				if( in_array( $key, array( 'ville', 'département', 'pays', 'code postal' ) ) ){
					if( $value != ''){
						$venue_array[] = $value;
					}
				}
			}
			echo '<p><i>' . implode( ", ", $venue_array ) . '</i></p>';
			?>
		</div>
		<?php
		if( $venue['lat'] != '' && $venue['lon'] ){
			?><div class="map">
			<iframe src="https://maps.google.com/maps?q=<?php echo $venue['lat'].",".$venue['lon'];?>&hl=es;z=14&output=embed" width="100%" height="350" frameborder="0" style="border:0; margin:0;" allowfullscreen></iframe>
		</div>
			<?php
		}
		?>
		<div style="clear: both;"></div>
	</div>
	<?php
}
?>
</div>
<div style="clear: both;"></div>
