 <div id="custom_coupon_tab" class="panel woocommerce_options_panel">
    <h5 class="ml-2">Smart Coupons and Discount Fields </h5>
        <div class="form-row mt-2 ml-2 mb-2 mt-3">
       <div class="col-sm-2">
          <h6 class="text-left">Offer Free Products</h6>
       </div>
       <div class="col-sm-5">
       
        <select class="form-control form-control-sm freeproducts" id="freeproducts" name="freeproducts[]" multiple>
          <option>Select Free Products</option>
        <?php
            $products = wc_get_products(array('status' => 'publish'));
            foreach ($products as $product) {
               $string_to_array = explode( ' , ', $addfree_products );
               $selected = in_array($product->get_id(), $string_to_array) ? 'selected="selected"' : '';
            ?>
            <option value="<?= esc_attr($product->get_id()); ?>" <?= $selected; ?>> <?php echo esc_html($product->get_name()); ?></option>
        <?php      
        }
        ?>
        </select>
       </div>
    </div>
    </div>