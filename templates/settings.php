<div class="wrap">
    <h2>woo-commerce custom order number setting page</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('wp_plugin_template-group_order_number'); ?>
        <?php @do_settings_fields('wp_plugin_template-group_order_number'); ?>

        <?php do_settings_sections('woo_commerce_custom_order_number'); ?>

        <?php @submit_button(); ?>
    </form>
</div>
