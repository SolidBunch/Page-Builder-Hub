<?php

// Init the widget
add_action( 'widgets_init', function () {
	register_widget( \PBH\Widgets\social_icons\widget::class );
} );
