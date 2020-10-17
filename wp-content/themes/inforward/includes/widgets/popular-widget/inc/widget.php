<?php
	$lastdays = '';

	$this->args = $args;
	$this->instance = wp_parse_args($instance, $this->defaults);

	extract($this->args);
	extract($this->instance);

	$this->instance['number'] = $this->number;

	if (empty($this->instance['meta_key'])) {
		$this->instance['meta_key'] = '_popular_views';
	}

	$this->time = date('Y-m-d', strtotime( "-{$lastdays} days", current_time('timestamp')));

	//start widget
	$output = $before_widget ."\n";
	if ($title) {
		$output  .= $before_title. $title . $after_title . "\n";
	}

	$output .= '<div class="events-holder">';
		switch ($type) {
			case 'popular':
				$output .= $this->get_most_viewed();
				break;
			case 'latest':
				$output .= $this->get_latest_posts();
				break;
		}
	$output .= '</div>';
	
	if ($link && $link != '') {
	$output .= '<a href="'.$link.'" target="_blank" class="info-btn">'. esc_html__('More News','inforward') .'</a>';
	}
	
	$output .=  $after_widget . "\n";
	
	echo wp_kses_post($output);