// BookingTour.js - Xử lý logic giao diện đặt tour (chọn ngày khởi hành, số lượng người, giá di chuyển)
function formatCurrency(num) {
	return Number(num).toLocaleString("vi-VN") + "đ";
}

function updateMovingPrice() {
	const departureSelect = document.getElementById("departure_id");
	const quantityInput = document.getElementById("quantity");
	const movingPriceValue = document.getElementById("moving-price-value");
	const movingTotalValue = document.getElementById("moving-total-value");

	if (!departureSelect || !movingPriceValue || !movingTotalValue) return;

	const quantity = parseInt(quantityInput.value) || 1;
	const selected = departureSelect.options[departureSelect.selectedIndex];
	const price =
		selected && selected.dataset.price ? parseInt(selected.dataset.price) : 0;

	movingPriceValue.textContent = price > 0 ? formatCurrency(price) : "0đ";
	movingTotalValue.textContent =
		price > 0 ? formatCurrency(price * quantity) : "0đ";
}

function updateQuantityLimit() {
	const departureSelect = document.getElementById("departure_id");
	const quantityInput = document.getElementById("quantity");

	if (!departureSelect || !quantityInput) return;

	const selected = departureSelect.options[departureSelect.selectedIndex];
	const max =
		selected && selected.dataset.max ? parseInt(selected.dataset.max) : null;

	if (max) {
		quantityInput.max = max;
		if (parseInt(quantityInput.value) > max) quantityInput.value = max;
	} else {
		quantityInput.max = "";
	}
}

document.addEventListener("DOMContentLoaded", function () {
	const departureSelect = document.getElementById("departure_id");
	const quantityInput = document.getElementById("quantity");

	if (!departureSelect) return;

	// Cập nhật giá khi chọn lịch khởi hành
	departureSelect.addEventListener("change", function () {
		updateQuantityLimit();
		updateMovingPrice();
	});

	// Cập nhật tổng phí khi thay đổi số lượng
	if (quantityInput) {
		quantityInput.addEventListener("input", function () {
			updateQuantityLimit();
			updateMovingPrice();
		});
	}

	// Khởi tạo lần đầu
	updateMovingPrice();
});
