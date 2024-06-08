<?php get_header(); ?>

<div class="container">
    <?php
    // Start the loop to display the post content
    while ( have_posts() ) : the_post();

        // Output the event title
        the_title('<h1>', '</h1>');

        // Output the event content
        the_content();

        // Retrieve and display the event date custom field
        $event_date = get_post_meta( get_the_ID(), 'event_date', true );
        if ($event_date) {
            echo esc_html__( 'Event Date: ', 'events-calendar' ) . esc_html( $event_date );
        }

    endwhile; // End of the loop.
    ?>
</div>

<?php get_footer(); ?>
