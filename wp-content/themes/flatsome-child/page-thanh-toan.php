<?php get_header() ?>
<?php
if (isset($_GET['key']) && is_wc_endpoint_url('order-received')) {
    // Lấy order
    $order_id = absint(get_query_var('order-received'));
    $order    = wc_get_order($order_id);
    wc_get_template('checkout/thankyou.php', array('order' => $order));
    get_footer();
    exit;
}
?>
<link rel='stylesheet' href='<?php echo get_home_url(); ?>/wp-content/themes/flatsome-child/assets/css/thanh-toan.css'>

<div class="checkout-container">
    <div class="checkout-inner">

        <!-- LEFT COLUMN -->
        <section class="left-column">

            <!-- Products card -->
            <section class="card card-products">
                <header class="card-header">
                    <div class="header-row">
                        <div class="col product-title">Danh sách sản phẩm</div>
                        <div class="col price-title text-right">Đơn giá</div>
                        <div class="col qty-title text-right">Số lượng</div>
                        <div class="col total-title text-right">Thành tiền</div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="branch-line">
                        <span class="icon icon-store">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path d="M4 6L12 2l8 4v2H4V6zM3 10h18v8a1 1 0 0 1-1 1h-3v-5H7v5H4a1 1 0 0 1-1-1v-8z" />
                            </svg>
                        </span>
                        <div class="branch-text">Chi nhánh kho HCM</div>
                    </div>
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                        $_product = $cart_item['data'];
                        $quantity = $cart_item['quantity'];
                        $line_total = $cart_item['line_total']; ?>
                        <article class="product-row">
                            <div class="product-info">
                                <img class="product-image" alt="<?php echo esc_attr($_product->get_name()); ?>" src="<?php echo esc_url(wp_get_attachment_image_url($_product->get_image_id(), 'full')); ?>">
                                <div class="product-meta">
                                    <div class="product-name"><?php echo esc_html($_product->get_name()); ?></div>
                                    <?php if (isset($cart_item['is_gift'])) : ?>
                                        <div class="product-gift-note" style="color:#008000;font-size:12px;margin-top:4px;">
                                            <?php echo isset($cart_item['gift_note']) ? esc_html($cart_item['gift_note']) : 'Sản phẩm khuyến mãi'; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="info-product-mb">
                                        <div class="product-price product-price-mb">
                                            <div class="price-current"><?php echo wc_price($_product->get_price()); ?></div>
                                            <?php if ($_product->get_regular_price() > $_product->get_sale_price()) : ?>
                                                <div class="price-old"><?php echo wc_price($_product->get_regular_price()); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-qty mb">x<?php echo esc_html($quantity); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-price product-price-pc">
                                <div class="price-current"><?php echo wc_price($_product->get_price()); ?></div>
                                <?php if ($_product->get_regular_price() > $_product->get_sale_price()) : ?>
                                    <div class="price-old"><?php echo wc_price($_product->get_regular_price()); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="product-qty pc">x<?php echo esc_html($quantity); ?></div>
                            <div class="product-line-total pc"><?php echo wc_price($line_total); ?></div>
                        </article>
                    <?php endforeach; ?>

                    <?php if (wc_coupons_enabled()) : ?>
                        <div class="woocommerce-coupon-form">
                            <?php woocommerce_checkout_coupon_form(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Shipping -->
            <section class="card card-shipping">
                <div class="shipping-header">
                    <div class="shipping-title">
                        <span class="icon icon-truck">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path d="M3 3h13v13H3zM18 8h3l-1 3h-2zM7 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm10 0a2 2 0 1 0 .001-4.001A2 2 0 0 0 17 19z" />
                            </svg>
                        </span>
                        <span class="shipping-text">Hình thức vận chuyển</span>
                    </div>
                </div>
                <div class="giao-hang">
                    <div class="shipping-custom-box">

                        <label class="ship-option">
                            <input type="radio" name="shipping_speed" value="Giao nhanh toàn quốc" checked>
                            <span class="ship-title">🚚 Giao nhanh toàn quốc</span>
                            <span class="ship-desc">Dự kiến 2-3 ngày</span>
                        </label>

                        <label class="ship-option">
                            <input type="radio" name="shipping_speed" value="Giao hoả tốc 4h">
                            <span class="ship-title">⚡ Hoả tốc 4h</span>
                            <span class="ship-desc">Chỉ áp dụng TP.HCM (Người nhận trả phí)</span>
                        </label>

                    </div>
                </div>
                <div class="shipping-body">
                    <div class="woocommerce-shipping-totals shipping">
                        <?php
                        $packages = WC()->shipping->get_packages();
                        foreach ($packages as $i => $package) {
                            if (!empty($package['rates'])) {
                                foreach ($package['rates'] as $rate_id => $rate) {
                                    $checked = WC()->session->get('chosen_shipping_methods')[$i] ?? '';
                        ?>
                                    <label class="shipping-method <?php echo ($checked === $rate_id) ? 'selected' : ''; ?>">
                                        <input type="radio" name="shipping_method[<?php echo $i; ?>]" value="<?php echo esc_attr($rate_id); ?>" <?php checked($checked, $rate_id); ?> data-index="<?php echo $i; ?>">
                                        <div class="method-name"><?php echo esc_html($rate->get_label()); ?></div>
                                        <div class="method-cost"><?php echo wc_price($rate->get_cost()); ?></div>
                                    </label>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <div id="checkout-summary" class="woocommerce-checkout-review-order-table"></div>
                </div>
            </section>

            <!-- PAYMENT MOVED HERE -->
            <section class="card card-payment">
                <h2 class="payment-title">Phương thức thanh toán</h2>
                <div class="payment-list">
                    <?php
                    $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
                    $chosen_gateway = WC()->session->get('chosen_payment_method');

                    foreach ($available_gateways as $gateway_id => $gateway) :
                        $checked = ($gateway_id === $chosen_gateway || (!$chosen_gateway && $gateway->id === 'cod')) ? 'checked' : '';
                    ?>
                        <label class="payment-item <?php echo $checked ? 'checked' : ''; ?>">
                            <input type="radio" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php echo $checked; ?> form="custom-checkout-form" required>
                            <div class="payment-content">
                                <div class="payment-name"><?php echo esc_html($gateway->get_title()); ?></div>
                                <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
                                    <div class="payment-note">(<?php echo wp_kses_post($gateway->get_description()); ?>)</div>
                                <?php endif; ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- WooCommerce Checkout Form -->
            <section class="card card-checkout-form" id="checkout-popup-content" style="display:none;">
                <h2 class="checkout-title">Thông tin thanh toán</h2>
                <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" id="custom-checkout-form">
                    <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>

                    <div id="customer_details">
                        <div class="col-1"><?php do_action('woocommerce_checkout_billing'); ?></div>
                        <div class="col-2"><?php do_action('woocommerce_checkout_shipping'); ?></div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="btn-confirm-address" class="button alt">
                            Xác nhận thông tin
                        </button>
                    </div>


                </form>
            </section>
        </section>

        <!-- RIGHT COLUMN (form + totals) -->
        <aside class="right-column">
            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" id="checkout-right-form">
                <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
                <section class="card card-address">
                    <?php if (is_user_logged_in()) : ?>
                        <div class="info-user-old">
                            <div class="address-top">
                                <div class="address-title">
                                    <span class="icon icon-location">
                                        <svg viewBox="0 0 24 24" width="18" height="18">
                                            <path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zM12 11.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z" />
                                        </svg>
                                    </span>
                                    <span class="address-label">Địa chỉ nhận hàng</span>
                                </div>
                                <a class="link-action" href="/tai-khoan/edit-address/van-chuyen/">Thay đổi ></a>
                            </div>
                            <?php
                            $user_id = get_current_user_id();
                            $first_name = get_user_meta($user_id, 'shipping_first_name', true);
                            $last_name = get_user_meta($user_id, 'shipping_last_name', true);
                            $address1 = get_user_meta($user_id, 'shipping_address_1', true);
                            $address2 = get_user_meta($user_id, 'shipping_address_2', true);
                            $city = get_user_meta($user_id, 'shipping_city', true);
                            $state = get_user_meta($user_id, 'shipping_state', true);
                            $country = get_user_meta($user_id, 'shipping_country', true);
                            $company = get_user_meta($user_id, 'shipping_company', true);
                            $phone = get_user_meta($user_id, 'shipping_phone', true);
                            $full_address = trim("$address1 $address2, $city, $state, $country");
                            ?>
                            <div class="address-body">
                                <div class="recipient">
                                    <strong><?php echo $last_name . ' ' . $first_name ?> | <?php echo $phone ?></strong>
                                </div>
                                <div class="address-line"><?php echo $full_address; ?></div>
                                <?php if (!empty($full_address)) : ?>
                                    <div class="address-tag"><?php echo !empty($company) ? 'Công ty' : 'Nhà riêng'; ?></div>
                                <?php endif; ?>
                            </div>
                            <hr class="card-divider">
                        </div>
                    <?php endif; ?>
                    <?php
                    $subtotal = WC()->cart->get_subtotal();
                    $discount_total = WC()->cart->get_discount_total();
                    $shipping_total = WC()->cart->get_shipping_total();
                    if ($shipping_total == 0) {
                        $packages = WC()->shipping->get_packages();
                        if (!empty($packages)) {
                            foreach ($packages as $package) {
                                if (!empty($package['rates'])) {
                                    $first_rate = reset($package['rates']);
                                    $shipping_total = $first_rate->cost;
                                    break;
                                }
                            }
                        }
                    }
                    $total_amount = $subtotal - $discount_total + $shipping_total;
                    ?>
                    <div class="mini-summary">
                        <div class="mini-line"><span>Tổng tiền hàng</span> <span class="subtotal-amount"><?php echo wc_price(WC()->cart->get_subtotal()); ?></span></div>
                        <div class="mini-line"><span>Phí vận chuyển</span> <span class="shipping-amount"><?php echo wc_price(WC()->cart->get_shipping_total()); ?></span></div>
                        <div class="mini-line voucher-line" style="<?php echo WC()->cart->has_discount() ? '' : 'display:none'; ?>">
                            <span>Giảm giá (Voucher)</span>
                            <span class="discount-amount"><?php echo wc_price(WC()->cart->get_discount_total() * -1); ?></span>
                        </div>
                    </div>
                    <hr class="card-divider">
                    <div class="checkout-total">
                        <div class="checkout-total-label">Tổng thanh toán</div>
                        <div class="checkout-total-amount"><?php echo WC()->cart->get_total(); ?></div>
                    </div>
                    <!-- Terms & Conditions -->
                    <p class="form-row terms wc-terms-and-conditions">
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                            <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox" name="terms" id="terms" required>
                            Tôi đồng ý với <a href="#" class="woocommerce-terms-and-conditions-link">Điều khoản dịch vụ</a>
                        </label>
                    </p>

                    <!-- Place Order button -->
                    <p class="form-row">
                        <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order">Đặt hàng</button>
                    </p>
                    <p class="disclaimer">
                        Nhấn "Đặt hàng" đồng nghĩa việc bạn đồng ý tuân theo
                        <a href="#" class="link-action">Chính sách xử lý dữ liệu cá nhân</a> và
                        <a href="#" class="link-action">Điều khoản giao dịch chung</a>.
                    </p>
                </section>
            </form>
            <?php if (! is_user_logged_in()) : ?>
                <button type="button" id="open-billing-popup" class="button alt">
                    Thông tin thanh toán
                </button>
            <?php endif; ?>
        </aside>

    </div>
</div>

<?php get_footer() ?>

<!-- Popup thông tin thanh toán -->
<div id="billing-popup" class="popup" style="display:none;">
    <div class="popup-inner">
        <span id="close-billing-popup" class="close-btn">✖</span>

        <!-- Chèn toàn bộ form checkout đã ẩn -->
        <div class="popup-body"></div>
    </div>
</div>


<script>
    jQuery(function($) {

        // Submit coupon form bằng AJAX
        $('#woocommerce-checkout-form-coupon').on('submit', function(e) {
            e.preventDefault();
            var form = this;

            $.post(form.action, $(form).serialize())
                .done(function() {
                    location.reload();
                })
                .fail(function() {
                    location.reload();
                });
        });
    });
</script>



<script>
    jQuery(function($) {
        // --- existing handlers ---
        $('#open-checkout-popup').on('click', function(e) {
            e.preventDefault();
            syncPaymentToPopup();
            $('#checkout-popup').fadeIn();
        });

        $('#close-checkout-popup').on('click', function() {
            $('#checkout-popup').fadeOut();
        });

        $('#woocommerce-checkout-form-coupon').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.post(form.action, $(form).serialize())
                .done(function() {
                    location.reload();
                })
                .fail(function() {
                    location.reload();
                });
        });

        // --- New: sync payment radios into popup hidden input ---
        function getSelectedPaymentFromMain() {
            var $checked = $('input[name="payment_method"]:checked').first();
            return $checked.length ? $checked.val() : null;
        }

        function syncPaymentToPopup() {
            var val = getSelectedPaymentFromMain();
            if (!val) {
                val = 'cod';
            }
            var $popupForm = $('#popup-checkout-form');
            var $hidden = $popupForm.find('input[name="payment_method"].from-main');
            if (!$hidden.length) {
                $hidden = $('<input>', {
                    type: 'hidden',
                    name: 'payment_method',
                    'class': 'from-main'
                }).appendTo($popupForm);
            }
            $hidden.val(val);
        }

        $(document).on('change', 'input[name="payment_method"]', function() {
            syncPaymentToPopup();
        });

        $('#open-checkout-popup').on('click', function() {
            setTimeout(function() {
                $('#terms').focus();
            }, 200);
        });
        syncPaymentToPopup();
    });


    jQuery(function($) {
        $(document).on('change', 'input[name="payment_method"]', function() {
            // Xóa checked ở tất cả label
            $('.payment-item').removeClass('checked');

            // Thêm checked vào label chứa radio được chọn
            $(this).closest('.payment-item').addClass('checked');
        });
    })
</script>


<script>
    jQuery(function($) {
        // Mở popup
        $('#open-checkout-popup').on('click', function(e) {
            e.preventDefault();
            $('#checkout-popup').fadeIn();
        });

        // Đóng popup
        $('#close-checkout-popup').on('click', function() {
            $('#checkout-popup').fadeOut();
        });

        // Khi bấm Xác nhận thanh toán trong popup
        $('#confirm-checkout-popup').on('click', function() {
            // Kiểm tra điều khoản
            if (!$('#terms_popup').is(':checked')) {
                alert('Bạn phải đồng ý điều khoản trước khi đặt hàng.');
                return;
            }

            // Lấy giá trị payment method từ popup và set vào form chính
            var payment = $('input[name="payment_method_popup"]:checked').val();
            $('#custom-checkout-form input[name="payment_method"]').val(payment);

            // Submit form chính
            $('#custom-checkout-form').submit();
        });
    });
</script>

<script>
    jQuery(function($) {
        $('#place_order').on('click', function(e) {
            e.preventDefault(); // tránh submit mặc định

            var $leftInputs = $('.left-column #customer_details').find('input, select, textarea');
            var $rightForm = $('#checkout-right-form');

            // Copy input billing/shipping
            $leftInputs.each(function() {
                var name = $(this).attr('name');
                var val = $(this).val();
                if (name) {
                    var $hidden = $rightForm.find('input[name="' + name + '"]');
                    if (!$hidden.length) {
                        $hidden = $('<input>').attr({
                            type: 'hidden',
                            name: name
                        }).appendTo($rightForm);
                    }
                    $hidden.val(val);
                }
            });

            // Copy payment method
            var payment = $('.left-column input[name="payment_method"]:checked').val();
            if (payment) {
                var $hiddenPayment = $rightForm.find('input[name="payment_method"]');
                if (!$hiddenPayment.length) {
                    $hiddenPayment = $('<input>').attr({
                        type: 'hidden',
                        name: 'payment_method'
                    }).appendTo($rightForm);
                }
                $hiddenPayment.val(payment);
            }

            // Copy shipping_speed
            var ship = $('input[name="shipping_speed"]:checked').val();
            if (ship) {
                var $hiddenShip = $rightForm.find('input[name="shipping_speed"]');
                if (!$hiddenShip.length) {
                    $hiddenShip = $('<input>').attr({
                        type: 'hidden',
                        name: 'shipping_speed'
                    }).appendTo($rightForm);
                }
                $hiddenShip.val(ship);
            }

            // Trigger WooCommerce checkout JS
            if (typeof $rightForm.trigger === 'function') {
                $rightForm.trigger('submit'); // trigger event, WooCommerce JS sẽ handle
            }
        });
    });
</script>



<script>
    jQuery(function($) {
        $(document).on('change', 'input[name^="shipping_method"]', function() {
            var $form = $('#custom-checkout-form'); // form checkout chính
            // Trigger WooCommerce update_checkout
            if (typeof $form.trigger === 'function') {
                $form.trigger('update_checkout');
            }
        });
    });

    jQuery(function($) {

        $(document.body).on('updated_checkout', function() {

            $.post(
                '<?php echo admin_url("admin-ajax.php"); ?>', {
                    action: 'get_cart_totals'
                },
                function(res) {

                    // cập nhật giá trị tổng
                    $('.subtotal-amount').html(res.subtotal);
                    $('.shipping-amount').html(res.shipping);
                    $('.checkout-total-amount').html(res.total);

                    // --- xử lý voucher ---
                    if (res.discount && res.discount !== '0') {
                        $('.discount-amount').html(res.discount);
                        $('.voucher-line').show();
                    } else {
                        $('.voucher-line').hide();
                    }

                },
                'json'
            );

        });

    });
</script>


<script>
    jQuery(function($) {

        // mở popup
        $('#open-billing-popup').on('click', function() {
            var html = $('#checkout-popup-content').html()
            $('#billing-popup .popup-body').html(html)
            $('#billing-popup').fadeIn()
        })

        // đóng popup
        $('#close-billing-popup').on('click', function() {
            $('#billing-popup').fadeOut()
        })
    })

    jQuery(function($) {

        $(document).on('click', '#open-billing-popup', function() {
            setTimeout(function() {
                // trong DOM gốc
                $('input[name="createaccount"]').prop('checked', true);

                // trong popup sau khi clone
                $('#billing-popup .popup-body').find('input[name="createaccount"]').prop('checked', true);
            }, 400);
        });

    });


    //ajax update thông tin đặt hàng
    jQuery(function($) {
        $(document).on('click', '#btn-confirm-address', function() {
            let $btn = $(this);
            // loading UI
            $btn.prop('disabled', true).addClass('loading').html('Đang lưu...');
            let data = {
                action: 'update_checkout_address'
            };
            $('#billing-popup :input').each(function() {
                let name = $(this).attr('name');
                if (name) {
                    data[name] = $(this).val();
                }
            });
            $.post('<?php echo admin_url("admin-ajax.php"); ?>', data, function(res) {
                // validate lỗi
                if (res.data && res.data.validate_error) {
                    showErrorToast(res.data.message);
                    $('[name="' + res.data.field + '"]').focus();
                    return; // STOP
                }
                if (res.success) {
                    showSuccessToast('Đã lưu & tạo tài khoản!');
                    setTimeout(function() {
                        location.reload();
                    }, 600);
                } else {
                    showErrorToast('Có lỗi xảy ra!');
                }

            }, 'json').always(function() {

                $btn.prop('disabled', false)
                    .removeClass('loading')
                    .html('Xác nhận thông tin');
            });
        });

    });


    // fancy toast
    function showSuccessToast(msg) {
        jQuery('body').append(`
        <div class="toast-success">${msg}</div>
    `);
        setTimeout(() => {
            jQuery('.toast-success').fadeOut(400, function() {
                jQuery(this).remove()
            });
        }, 1000);
    }

    function showErrorToast(msg) {
        jQuery('body').append(`
        <div class="toast-error">${msg}</div>
    `);
        setTimeout(() => {
            jQuery('.toast-error').fadeOut(400, function() {
                jQuery(this).remove()
            });
        }, 2000);
    }


    jQuery(function($) {
        $(document.body).on('checkout_error', function() {
            // mở popup
            $('#open-billing-popup').trigger('click');

            // cuộn lên đầu popup cho dễ xem
            setTimeout(function() {
                $('#billing-popup .popup-inner').animate({
                    scrollTop: 0
                }, 300);
            }, 300);
        });
    });

    // Tự đồng bộ thông tin sang bảng shipping_
    jQuery(function($) {

        // khi blur, change, keyup các ô billing
        $(document).on('change keyup blur', '[name^="billing_"]', function() {

            let billingName = $(this).attr('name');

            // convert billing_ → shipping_
            let shippingName = billingName.replace('billing_', 'shipping_');

            // gán value qua shipping
            $('[name="' + shippingName + '"]').val($(this).val());
        });

    });
</script>