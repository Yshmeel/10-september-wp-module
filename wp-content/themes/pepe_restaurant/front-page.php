<?php get_header(); ?>

<div class="header">
    <div class="container">
        <div class="header__top">
            <div class="header__top--logo">
                <?php echo get_custom_logo(); ?>
            </div>

            <div class="header__top--menu">
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'main-menu',
                            'link_before' => '<span itemprop="name">',
                            'link_after' => '</span>'
                        )
                    );
                ?>
            </div>
        </div>

        <div class="header__content">
            <?php echo do_shortcode('[smartslider3 slider="2"]'); ?>
        </div>
    </div>
</div>

<div class="reservation-modal modal">
    <div class="modal-dialog">
        <div class="reservation-modal-title">
            Book a table
        </div>

        <div class="reservation-modal-form">
            <form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
                <input type="hidden" name="action" value="create_reservation">

                <div class="form-group">
                    <label for="reservation-name">Name</label>
                    <input type="text" name="name" id="reservation-name" required />
                </div>

                <div class="form-group">
                    <label for="reservation-email">E-mail</label>
                    <input type="email" name="email" id="reservation-email" required />
                </div>

                <div class="form-group">
                    <label for="reservation-date">Date</label>
                    <input type="date" name="date" id="reservation-date" required />
                </div>

                <div class="form-group">
                    <label for="reservation-name">Time</label>
                    <input type="time" name="time" id="reservation-time" required />
                </div>

                <div class="form-group">
                    <label for="reservation-visitors">Visitors Count</label>
                    <input type="number" name="visitors" id="reservation-visitors" required />
                </div>

                <div class="form-button">
                    <button type="submit" class="btn">
                        Submit
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    jQuery(document).ready(function() {
        const $reservationModal = jQuery('.reservation-modal');

        jQuery('.book-a-table').click(function() {
            $reservationModal.fadeIn(300).css('display', 'flex');
        });

        jQuery(document).mouseup(function(e) {
            if(jQuery(e.target).is($reservationModal)) {
                $reservationModal.fadeOut(300);
            }
        });
    });
</script>
