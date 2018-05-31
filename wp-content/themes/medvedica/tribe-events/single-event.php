<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.3
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

$taxonomies = get_the_taxonomies();
$onclick = '';
if (isset($taxonomies['tribe_events_cat']) && stripos($taxonomies['tribe_events_cat'], 'Тело как источник ресурса')) {
    $onclick = 'onclick="yaCounter48194084.reachGoal(\'btn_telo_kak_istochnic\'); return true;" value="Заказать"';
}
//log_me(get_the_category_list());
//log_me(get_the_taxonomies());
//log_me();
//log_me(get_cat_name());

?>

<div id="tribe-events-content" class="tribe-events-single">

    <p class="tribe-events-back">
        <a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
    </p>

    <!-- Notices -->
    <?php tribe_the_notices() ?>

    <?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

    <div class="tribe-events-schedule tribe-clearfix">
        <?php echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
    </div>

    <!-- Event header -->
    <div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
        <!-- Navigation -->
        <h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
        <ul class="tribe-events-sub-nav">
            <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
            <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
        </ul>
        <!-- .tribe-events-sub-nav -->
    </div>
    <!-- #tribe-events-header -->

    <?php while ( have_posts() ) :  the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Event featured image, but exclude link -->
            <?php echo tribe_event_featured_image( $event_id, 'event-img', false ); ?>
            <? if (!tribe_is_past_event()): ?>
            <button <?=$onclick?> class="dt-btn register-btn" data-id="<?=$event_id?>" data-cost="<?=tribe_get_cost()?>" data-date="<?=esc_attr(tribe_get_start_date())?>" data-title="<?=esc_attr(tribe_get_events_title())?>">Записаться</button>
            <br><br>
            <? endif; ?>
            <!-- Event content -->
            <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>

            <div class="tribe-events-single-event-description tribe-events-content">
                <?php the_content(); ?>
            </div>
            <br>
            <hr style="width: 50%;">
            <br>
            <?php if ( tribe_get_cost() ) : ?>
                <div class="tribe-events-event-cost">
                    <strong>Стоимость</strong> &emsp;
                    <span class="ticket-cost"><?php echo tribe_get_cost( null, true ); ?></span>&emsp;
                <? if (!tribe_is_past_event()): ?>
                    <button <?=$onclick?> class="dt-btn register-btn" data-id="<?=$event_id?>" data-cost="<?=tribe_get_cost()?>" data-date="<?=esc_attr(tribe_get_start_date())?>" data-title="<?=esc_attr(tribe_get_events_title())?>">Записаться</button>
                <?php endif; ?>
                </div>

            <?php endif; ?>
            <!-- .tribe-events-single-event-description -->
            <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

            <!-- Event meta -->
            <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
            <?php tribe_get_template_part( 'modules/meta' ); ?>
            <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
        </div> <!-- #post-x -->
        <?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
    <?php endwhile; ?>

    <!-- Event footer -->
    <div id="tribe-events-footer">
        <!-- Navigation -->
        <h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
        <ul class="tribe-events-sub-nav">
            <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
            <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
        </ul>
        <!-- .tribe-events-sub-nav -->
    </div>
    <!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){
        jQuery('.register-btn').click(function(){
            jQuery("#reg-event-name").val(jQuery(this).data('title')).attr('readonly', true);
            jQuery("#reg-event-date").val(jQuery(this).data('date')).attr('readonly', true);
            jQuery("#reg-event-id").val(jQuery(this).data('id')).attr('readonly', true);
            jQuery("#reg-event-cost").val(jQuery(this).data('cost')).attr('readonly', true);
            jQuery("#popmake-1591").popmake('open');
        });
    });

    function sendYandex() {
        var form = jQuery('<form>', {
            'action': 'https://money.yandex.ru/eshop.xml',
            'method': 'post'
        });
        var phone = jQuery("#reg-phone");
        jQuery('body').append(form);
        jQuery(form).append(jQuery('<input>', {'name': 'shopId', 'value': 191334, 'type': 'hidden'}));
        jQuery(form).append(jQuery('<input>', {'name': 'scid', 'value': 717481, 'type': 'hidden'}));
        jQuery(form).append(jQuery('<input>', {'name': 'sum', 'value': jQuery("#reg-event-cost").val(), 'type': 'hidden'}));
        jQuery(form).append(jQuery('<input>', {'name': 'paymentType', 'value': 'AC', 'type': 'hidden'}));
        jQuery(form).append(jQuery('<input>', {'name': 'custName', 'value': jQuery("#reg-name").val(), 'type': 'hidden'}));
        jQuery(form).append(jQuery('<input>', {'name': 'customerNumber', 'value': phone.val(), 'type': 'hidden'}));
        jQuery(form).append(jQuery('<input>', {'name': 'cps_phone', 'value': phone.val(), 'type': 'hidden'}));
        jQuery(form).append(jQuery('<input>', {'name': 'cps_email', 'value': jQuery("#reg-email").val(), 'type': 'hidden'}));

        form.submit();
    }

    document.addEventListener( 'wpcf7mailsent', function( event ) {
        console.log(event);
        setInterval(function(){
            jQuery("#popmake-1591").popmake('close');
        }, 500);
        if (jQuery("#reg-payonline").find('input').prop('checked')) {
            sendYandex();
        }
        return false;
    }, false );
</script>