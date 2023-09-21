<h5 class="ml-2">Smart Coupons and Discount Fields </h5>
<div class="form-row">  
  <div >
        <p class="form-field custom-coupon-field">
            <label for="custom_coupon_field"><?php esc_html_e('Url Coupons', 'textdomain'); ?></label>
            <input type="checkbox" name="custom_coupon_field" id="custom_coupon_field" value="1" <?php checked($custom_field_value, '1'); ?> />
        </p>
    </div>
    <div class="col-sm-6 col-md-6 couponsdiv" style="display: none;">
        <input type="text" class="form-control form-control-sm couponlink mt-2" name="couponlink" value="<?php echo $couponlink; ?>" id="couponlink" >    
    </div>
    <div class="col-sm-2 col-md-2 couponsdiv" style="display: none;">
    <button type="button" class="btn btn-sm btn-outline-primary copylink mt-2" id="copylink">Copy</button>
    </div>
</div>