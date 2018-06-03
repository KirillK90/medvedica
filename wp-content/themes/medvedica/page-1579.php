<?php
/**
 * The template for displaying all pages.
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package The7
 * @since   1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = presscore_config();
$config->set( 'template', 'page' );

get_header();
?>

<?php if ( presscore_is_content_visible() ): ?>

    <div id="content" class="content" role="main">

		<h1>xxx</h1>

        <form action="https://demomoney.yandex.ru/eshop.xml" method="post" target="_blank">
            <!-- Обязательные поля -->
            <input name="shopId" value="151" type="hidden"/>
            <input name="shopArticleId" value="151" type="hidden"/>
            <input name="scid" value="59816" type="hidden"/>
            <input name="sum" value="100" type="hidden">
            <input name="customerNumber" value="100500" type="hidden"/>
            <input name="paymentType" value="AC" type="hidden"/>
            <input type="hidden" name="rebillingOn" value="true">
            <input type="submit" value="Заплатить"/>
        </form>
        <br>

    </div><!-- #content -->

	<?php do_action( 'presscore_after_content' ) ?>

<?php endif // if content visible ?>

<?php get_footer() ?>