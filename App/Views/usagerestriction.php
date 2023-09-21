  <div class="options_group">
        <h5 class="ml-2">Smart Coupons and Discount Fields </h5>
        <p class="form-field custom-coupon-field">
            <label for="custom_first_order"><?php esc_html_e('Apply Coupon For The First Order Only', 'textdomain'); ?></label>
            <input type="checkbox" name="custom_first_order" id="custom_first_order" value="1" <?php checked($custom_first_order, '1'); ?> />
            Check this box for this coupon to apply only for the first order of the customer
        </p>
    </div>
    <div class="form-row mt-2 ml-2">
       <div class="col-sm-4">
          <h6 class="text-left">Include User Roles</h6>
       </div>
       <div class="col-sm-5">
        <select class="form-control form-control-sm userroles" id="includeuser" name="includeuser[]" multiple>
          <option>Select include user roles</option>
        <?php
             $roles = wp_roles()->get_names();
             foreach ($roles as $role_key => $role_name) {

             $string_to_array = explode( ' , ', $saved_include_user_role );
             $selected = in_array($role_key, $string_to_array) ? 'selected="selected"' : '';
        ?>
             <option value="<?= esc_attr($role_key) ?>" <?= $selected; ?>> <?php echo esc_html($role_name) ?></option>
        <?php      
              }
        ?>
          
        </select>
       </div>
    </div>
    <div class="form-row mt-2 ml-2 mb-2">
       <div class="col-sm-4">
          <h6 class="text-left">Exclude User Roles</h6>
       </div>
       <div class="col-sm-5">
        <select class="form-control form-control-sm userroles" id="excludeuser" name="excludeuser[]" multiple>
          <option>Select exclude user roles</option>
            <?php
             $roles = wp_roles()->get_names();
              foreach ($roles as $role_key => $role_name) {

              $string_to_array = explode( ' , ', $saved_exclude_user_role );
              $selected = in_array($role_key, $string_to_array) ? 'selected="selected"' : '';
        ?>
             <option value="<?= esc_attr($role_key) ?>" <?= $selected; ?>> <?php echo esc_html($role_name) ?></option>
        <?php      
              }
        ?>
        </select>
       </div>
    </div>