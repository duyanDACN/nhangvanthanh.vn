<?php

/**
 * Product with no sidebar.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.16.0
 */

?>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />
<script>
	const ajax_nonce = "<?php echo wp_create_nonce('custom_add_to_cart_nonce'); ?>";
</script>
<link rel='stylesheet' href='<?php echo get_home_url(); ?>/wp-content/themes/flatsome-child/assets/css/chi-tiet-san-pham.css'>
<script>
	tailwind.config = {
		darkMode: "class",
		theme: {
			extend: {
				colors: {
					primary: "#10B981",
					"background-light": "#FFFFFF",
					"background-dark": "#111827",
					"surface-light": "#F9FAFB",
					"surface-dark": "#1F2937",
					"border-light": "#E5E7EB",
					"border-dark": "#374151",
					"text-primary-light": "#1F2937",
					"text-primary-dark": "#F9FAFB",
					"text-secondary-light": "#6B7280",
					"text-secondary-dark": "#9CA3AF",
				},

			},
		},
	};
</script>
<div class="product-container">
	<div class="product-main">
		<div class="row content-row mb-0 row-chi-tiet">
			<div class="bg-background-light dark:bg-background-dark text-text-primary-light dark:text-text-primary-dark font-sans">
				<div class="container mx-auto p-4 md:p-8">
					<main class="grid grid-cols-1 lg:grid-cols-[2fr_2fr_1fr] gap-8">
						<div class="lg:col-span-1">
							<?php echo woocommerce_show_product_images(); ?>
						</div>
						<div class="lg:col-span-1">
							<h1 class="text-2xl font-bold text-text-primary-light dark:text-text-primary-dark mb-2">
								<?php the_title(); ?>
							</h1>
							<div class="text-sm text-text-secondary-light dark:text-text-secondary-dark mb-4">
								<?php
								global $product;

								if ($product->is_in_stock()) {
									$qty = $product->get_stock_quantity();

									if ($qty !== null) {
										echo '<span class="stock in-stock text-primary">Còn ' . $qty . ' trong kho</span>';
									} else {
										echo '<span class="stock in-stock text-primary">Còn hàng</span>';
									}
								} else {
									echo '<span class="stock out-of-stock text-red-600">Hết hàng</span>';
								}
								?>
								<span class="mx-2">|</span>
								<span><?php echo wc_get_product(get_the_ID())->get_sku(); ?></span>
							</div>
							<?php
							global $product;

							if ($product->is_type('variable')) :
								$variations = $product->get_available_variations();
							?>

								<div class="flex flex-wrap gap-3 mb-4 product-variations">
									<?php foreach ($variations as $variation) :
										$variation_id = $variation['variation_id'];
										$label = implode('', array_values($variation['attributes']));
										$image = $variation['image']['full_src'];
										$price = $variation['display_price']; // giá numeric
									?>
										<button
											class="variation-btn px-4 py-2 text-sm border border-border-light dark:border-border-dark rounded bg-surface-light dark:bg-surface-dark text-text-secondary-light hover:border-primary transition"
											data-variation-id="<?php echo $variation_id; ?>"
											data-image="<?php echo esc_url($image); ?>"
											data-price="<?php echo esc_attr($price); ?>">
											<?php echo esc_html($label); ?>
										</button>
									<?php endforeach; ?>
								</div>

								<input type="hidden" name="variation_id" id="variation_id" value="">
							<?php endif; ?>
							<div class="product-price text-3xl font-bold text-red-600 mb-6"></div>
							<div class="mb-4 choose-quality">
								<label for="custom_quantity" class="block text-sm font-medium text-sl">Số lượng</label>

								<div class="flex items-center">
									<button type="button" id="qty_minus" class="qty-btn">-</button>

									<input
										type="number"
										id="custom_quantity"
										value="1"
										min="1"
										class="">

									<button type="button" id="qty_plus" class="qty-btn">+</button>
								</div>
							</div>

							<div class="flex flex-col sm:flex-row gap-3 mb-4">
								<button id="custom-add-to-cart"
									data-product-id="<?php echo get_the_ID(); ?>"
									class="flex-grow w-full bg-primary text-white font-bold py-3 px-6 rounded-lg flex items-center justify-center text-lg hover:opacity-90 transition relative">
									<span class="material-icons-outlined mr-2">shopping_cart</span>
									<span class="btn-text">Mua ngay</span>
									<span class="spinner hidden absolute right-4">
										<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
											<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
											<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
										</svg>
									</span>
								</button>
								<button class="flex-grow w-full border border-primary text-primary font-bold py-3 px-6 rounded-lg flex items-center justify-center text-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition">
									<span class="material-icons-outlined mr-2">chat_bubble_outline</span>
									Chat Zalo
								</button>
							</div>
							<p class="text-left text-sm text-text-secondary-light dark:text-text-secondary-dark mb-3">Zalo phục vụ từ 8:00 - 21:30</p>

							<div class="space-y-4 mt-3 mb-6 info-giao-hang">
								<?php woocommerce_template_single_excerpt(); ?>


								<div class="border border-border-light dark:border-border-dark rounded-lg p-4">
									<?php
									$money_min = get_field('money_min');
									$gift_id = get_field('product_gift');
									?>
									<h3 class="font-bold mb-3 text-text-primary-light dark:text-text-primary-dark">Khuyến mãi</h3>
									<div class="flex items-center text-sm mb-3">
										<span class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full mr-2">Quà</span>
										<span class="text-text-secondary-light dark:text-text-secondary-dark">
											<?php echo 'Nhận được khuyến mãi khi mua từ ' . number_format($money_min, 0, ',', '.') . 'đ'; ?>
										</span>
									</div>
									<div class="flex items-start bg-green-50 dark:bg-green-900/20 border border-dashed border-primary rounded p-3">
										<span class="bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400 text-xs font-bold px-1.5 py-0.5 rounded-full mr-3 mt-1">Lưu ý</span>
										<div class="flex-1">
											<?php
											$gift = wc_get_product($gift_id);
											?>
											<p class="text-sm text-primary font-medium">
												<?php echo $gift ? $gift->get_name() : ''; ?>
											</p>
											<p class="text-xs text-text-secondary-light dark:text-text-secondary-dark mt-1">Lưu ý: Chỉ áp dụng cho tổng tiền khi mua sản phẩm này</p>
										</div>
									</div>
								</div>
								<div class="border border-border-light dark:border-border-dark rounded-lg p-4">
									<a class="flex items-center justify-between mb-4" href="#">
										<h3 class="font-bold text-text-primary-light dark:text-text-primary-dark">Cửa hàng có sẵn hàng</h3>
									</a>
									<ul class="space-y-3 text-sm">
										<li class="flex justify-between items-center">
											<span class="text-text-secondary-light dark:text-text-secondary-dark">119 Bình Long Phường Bình Trị Đông Thành Phố Hồ Chí Minh, Việt Nam</span>
											<a class="text-blue-500 hover:underline text-nowrap" href="https://maps.app.goo.gl/tGsVB62aNm8P6Uoc8">Bản đồ</a>
										</li>
										<li class="flex justify-between items-center">
											<span class="text-text-secondary-light dark:text-text-secondary-dark">Thôn Vĩnh Tuy, Xã Ba Gia, Tỉnh Quảng Ngãi</span>
											<a class="text-blue-500 hover:underline text-nowrap" href="https://maps.app.goo.gl/cjsS3H3Uwy3bRGKaA">Bản đồ</a>
										</li>
									</ul>
								</div>

							</div>
						</div>
						<div class="row-km open-cf7-popup">
							<picture>
								<source srcset="https://img.tgdd.vn/imgt/ankhang/f_webp,fit_outside,quality_95/https://cdnv2.tgdd.vn/mwg-static/ankhang/Banner/c2/e2/c2e287b50593cb7eed42da446138fe5a.png" media="(min-width: 1200px)">
								<source srcset="https://img.tgdd.vn/imgt/ankhang/f_webp,fit_outside,quality_95/https://cdnv2.tgdd.vn/mwg-static/ankhang/Banner/c2/e2/c2e287b50593cb7eed42da446138fe5a.png" media="(min-width: 768px)">
								<source srcset="https://img.tgdd.vn/imgt/ankhang/f_webp,fit_outside,quality_95/https://cdnv2.tgdd.vn/mwg-static/ankhang/Banner/c2/e2/c2e287b50593cb7eed42da446138fe5a.png" media="(min-width: 360px)">
								<img src="https://img.tgdd.vn/imgt/ankhang/f_webp,fit_outside,quality_95/https://cdnv2.tgdd.vn/mwg-static/ankhang/Banner/c2/e2/c2e287b50593cb7eed42da446138fe5a.png"
									alt=""
									loading="eager"
									class="rounded-12px nhan-khuyen-mai object-contain"
									style="width:100%; cursor:pointer;">
							</picture>
							<div class="support-policy mt-4">
								<h3><span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
											<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
										</svg></span> CHÍNH SÁCH HỖ TRỢ</h3>
								<div class="policy-item policy-first">
									<img src="https://bizweb.dktcdn.net/100/594/142/themes/1038544/assets/policy_image_1.png?1762221596595">
									<p>Miễn phí vận chuyển tại TP.HCM</p>
								</div>

								<div class="policy-item">
									<img src="https://bizweb.dktcdn.net/100/594/142/themes/1038544/assets/policy_image_2.png?1762221596595">
									<p>Bảo hành chính hãng toàn quốc</p>
								</div>

								<div class="policy-item">
									<img src="https://bizweb.dktcdn.net/100/594/142/themes/1038544/assets/policy_image_3.png?1762221596595">
									<p>Cam kết chính hãng 100%</p>
								</div>

								<div class="policy-item">
									<img src="https://bizweb.dktcdn.net/100/594/142/themes/1038544/assets/policy_image_4.png?1762221596595">
									<p>Hỗ trợ đổi trả, bảo hành</p>
								</div>
							</div>
						</div>

					</main>
					<div class="product-footer">
						<div class="container">
							<?php
							do_action('woocommerce_after_single_product_summary');
							?>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<div id="cf7-popup" class="cf7-overlay">
	<div class="cf7-box">

		<span class="close-cf7">✕</span>

		<?php echo do_shortcode('[contact-form-7 id="42c0307" title="form tư vấn"]'); ?>

	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const qtyInput = document.getElementById('custom_quantity');
		const btnMinus = document.getElementById('qty_minus');
		const btnPlus = document.getElementById('qty_plus');

		if (btnMinus && btnPlus && qtyInput) {
			btnMinus.addEventListener('click', () => {
				let val = parseInt(qtyInput.value);
				if (val > 1) {
					qtyInput.value = val - 1;
					qtyInput.dispatchEvent(new Event('input'));
				}
			});

			btnPlus.addEventListener('click', () => {
				let val = parseInt(qtyInput.value);
				qtyInput.value = val + 1;
				qtyInput.dispatchEvent(new Event('input'));
			});
		}
		const variationBtns = document.querySelectorAll('.variation-btn');
		const mainImage = document.querySelector('.main-product-image');
		const variationIdInput = document.getElementById('variation_id');
		const priceTag = document.querySelector('.product-price');

		if (variationBtns.length) {
			// active mặc định button đầu tiên
			const firstBtn = variationBtns[0];
			setActiveVariation(firstBtn);

			// sự kiện click
			variationBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					setActiveVariation(this);
				});
			});
		}

		function setActiveVariation(btn) {
			// reset all
			variationBtns.forEach(b => {
				b.classList.remove('border-primary', 'bg-green-50', 'dark:bg-green-900/20', 'text-primary', 'font-medium');
			});

			// active button
			btn.classList.add('border-primary', 'bg-green-50', 'dark:bg-green-900/20', 'text-primary', 'font-medium');

			// set variation id
			variationIdInput.value = btn.dataset.variationId;

			// đổi ảnh
			if (mainImage && btn.dataset.image) mainImage.src = btn.dataset.image;

			// đổi giá
			if (priceTag && btn.dataset.price) {
				const qty = document.getElementById('custom_quantity')?.value || 1;
				priceTag.textContent = formatPrice(btn.dataset.price * qty);
			}
		}


		if (qtyInput) {
			qtyInput.addEventListener('input', function() {
				const activeBtn = document.querySelector('.variation-btn.border-primary');
				if (activeBtn) {
					const price = activeBtn.dataset.price;
					priceTag.textContent = formatPrice(price * this.value);
				}
			});
		}

		function formatPrice(value) {
			return parseFloat(value).toLocaleString('vi-VN') + 'đ';
		}
	});


	document.addEventListener('DOMContentLoaded', function() {
		const addToCartBtn = document.getElementById('custom-add-to-cart');

		addToCartBtn.addEventListener('click', function() {

			const productId = this.dataset.productId;
			const variationId = document.getElementById('variation_id')?.value || '';
			const quantity = document.getElementById('custom_quantity')?.value || 1;

			const spinner = this.querySelector('.spinner');
			const btnText = this.querySelector('.btn-text');

			// Loading
			spinner.classList.remove('hidden');
			btnText.classList.add('hidden');
			this.disabled = true;

			// dữ liệu gửi lên PHP
			const formData = new FormData();
			formData.append('action', 'custom_add_to_cart');
			formData.append('product_id', productId);
			formData.append('quantity', quantity);
			formData.append('_ajax_nonce', ajax_nonce);
			if (variationId) formData.append('variation_id', variationId);

			// gọi AJAX WordPress
			fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
					method: "POST",
					body: formData,
					credentials: "same-origin",
					headers: {
						"X-Requested-With": "XMLHttpRequest"
					}
				})
				.then(response => response.text())
				.then(text => {

					console.log("AJAX RESPONSE:", text);

					let data = {};
					try {
						data = JSON.parse(text);
					} catch (e) {
						console.error("JSON parse error:", e);
					}

					if (data.success) {
						window.location.href = "<?php echo wc_get_checkout_url(); ?>";
					}
				})
				.catch(err => console.error(err))
				.finally(() => {
					// reset UI
					spinner.classList.add('hidden');
					btnText.classList.remove('hidden');
					addToCartBtn.disabled = false;
				});
		});
	});


	function updateMiniCart() {
		fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=woocommerce_get_refreshed_fragments', {
				method: 'POST'
			})
			.then(res => res.json())
			.then(data => {
				if (data && data.fragments) {
					Object.keys(data.fragments).forEach(function(key) {
						const el = document.querySelector(key);
						if (el) el.outerHTML = data.fragments[key];
					});
				}
			});
	}


	document.addEventListener("DOMContentLoaded", function() {

		const box = document.querySelector(".product-tabs_detail");

		if (!box) return;

		// Nếu nội dung ngắn thì thôi khỏi tạo nút
		if (box.scrollHeight <= 300) return;

		// Tạo button
		const btn = document.createElement("button");
		btn.id = "toggle-detail";
		btn.className = "mx-auto block mt-4 text-primary font-medium";
		btn.innerHTML = "Xem thêm ▼";

		// Chèn nút ngay sau product-tabs_detail
		box.parentNode.insertBefore(btn, box.nextSibling);

		btn.addEventListener("click", function() {
			box.classList.toggle("show-full");

			if (box.classList.contains("show-full")) {
				btn.innerHTML = "Thu gọn ▲";
			} else {
				btn.innerHTML = "Xem thêm ▼";
				box.scrollIntoView({
					behavior: "smooth",
					block: "start"
				});
			}
		});

	});


document.addEventListener("DOMContentLoaded", function() {

    const openBtn = document.querySelector('.open-cf7-popup picture'); 
    const popup = document.getElementById('cf7-popup');
    const closeBtn = document.querySelector('.close-cf7');

    if (!openBtn || !popup) return;

    openBtn.addEventListener("click", function() {
        popup.style.display = "flex";
        document.body.style.overflow = "hidden";
    });

    closeBtn.addEventListener("click", function() {
        popup.style.display = "none";
        document.body.style.overflow = "";
    });

    popup.addEventListener("click", function(e) {
        if (e.target === popup) {
            popup.style.display = "none";
            document.body.style.overflow = "";
        }
    });

});
</script>