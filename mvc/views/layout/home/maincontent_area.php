<?php require_once 'slider_area.php'; ?>

<?php require_once 'promo_area.php'; ?>

<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title">Bánh mới</h2>
                    <div class="product-carousel">
                        <?php echo $data['latest_product']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End main content area -->

<?php require_once 'brands_area.php'; ?>

<?php require_once 'product_widget_area.php'; ?>