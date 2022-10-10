<div class="wrap wc-cancel-order-list">
	<h2><?php echo __('Cancellation Request','wc-cancel-order'); ?></h2>
    <form method="post">
        <?php
        $dashboard = new WC_Cancel_Dashboard;
        $dashboard->prepare_items();
        $dashboard->display();
        ?>
    </form>
</div>