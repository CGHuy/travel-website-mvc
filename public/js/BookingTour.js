function validateBookingForm() {
	const name = document.getElementById("contact_name");
	const phone = document.getElementById("contact_phone");
	const email = document.getElementById("contact_email");
	const departure = document.getElementById("departure_id");
	const quantity = document.getElementById("quantity");
	const bookBtn = document.querySelector(
		'button[form="booking-form"], button[type="submit"]'
	);

	// Kiểm tra các trường bắt buộc
	let valid = true;
	if (!name || !name.value.trim()) valid = false;
	if (!phone || !phone.value.trim()) valid = false;
	if (!email || !email.value.trim()) valid = false;
	if (!departure || !departure.value) valid = false;
	if (!quantity || !quantity.value || parseInt(quantity.value) < 1)
		valid = false;

	if (bookBtn) {
		if (valid) {
			bookBtn.disabled = false;
			bookBtn.classList.remove("disabled");
			bookBtn.style.opacity = "";
			bookBtn.style.pointerEvents = "";
		} else {
			bookBtn.disabled = true;
			bookBtn.classList.add("disabled");
			bookBtn.style.opacity = "0.6";
			bookBtn.style.pointerEvents = "none";
		}
	}
}
// BookingTour.js - Xử lý logic giao diện đặt tour (chọn ngày khởi hành, số lượng người, giá di chuyển)
function formatCurrency(num) {
	return Number(num).toLocaleString("vi-VN") + "đ";
}

function updateMovingPrice() {
	const departureSelect = document.getElementById("departure_id");
	const quantityInput = document.getElementById("quantity");
	const movingPriceValue = document.getElementById("moving-price-value");
	const movingTotalValue = document.getElementById("moving-total-value");
	const tourMovingTotal = document.getElementById("tour-moving-total");

	if (!departureSelect || !movingPriceValue || !movingTotalValue) return;

	const quantity = parseInt(quantityInput.value) || 1;
	const selected = departureSelect.options[departureSelect.selectedIndex];
	const price =
		selected && selected.dataset.price ? parseInt(selected.dataset.price) : 0;

	movingPriceValue.textContent = price > 0 ? formatCurrency(price) : "0đ";
	movingTotalValue.textContent =
		price > 0 ? formatCurrency(price * quantity) : "0đ";

	if (tourMovingTotal) {
		tourMovingTotal.textContent =
			price > 0 ? formatCurrency(price * quantity) : "Chưa chọn điểm khởi hành";
	}
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

function updateTourCost() {
	const quantityInput = document.getElementById("quantity");
	const tourQuantity = document.getElementById("tour-quantity");
	const tourCost = document.getElementById("tour-cost");
	const movingTotalValue = document.getElementById("moving-total-value");
	const tourTotalAmount = document.getElementById("tour-total-amount");

	if (
		!quantityInput ||
		!tourQuantity ||
		!tourCost ||
		!movingTotalValue ||
		!tourTotalAmount
	)
		return;

	const quantity = parseInt(quantityInput.value) || 1;
	const tourCard = document.querySelector(".tour-info");
	const pricePerPerson = tourCard
		? parseInt(tourCard.getAttribute("data-price-per-person"))
		: 0;

	tourQuantity.textContent = quantity;

	let tourCostValue = 0;
	if (pricePerPerson > 0) {
		tourCostValue = pricePerPerson * quantity;
		tourCost.textContent = formatCurrency(tourCostValue);
	}

	// Lấy tổng phí di chuyển (đã format, cần chuyển về số)
	let movingTotal = 0;
	const departureSelect = document.getElementById("departure_id");
	const selectedDeparture = departureSelect ? departureSelect.value : "";
	const movingText = movingTotalValue.textContent.replace(/\D/g, "");
	if (movingText) {
		movingTotal = parseInt(movingText);
	}

	// Nếu chưa chọn lịch khởi hành thì báo chưa đủ thông tin
	if (!selectedDeparture) {
		tourTotalAmount.textContent = "Chưa chọn đủ thông tin";
	} else {
		// Tổng tiền = chi phí tour + tổng phí di chuyển
		const total = tourCostValue + movingTotal;
		tourTotalAmount.textContent = formatCurrency(total);
	}
}

document.addEventListener("DOMContentLoaded", function () {
	const departureSelect = document.getElementById("departure_id");
	const quantityInput = document.getElementById("quantity");
	const nameInput = document.getElementById("contact_name");
	const phoneInput = document.getElementById("contact_phone");
	const emailInput = document.getElementById("contact_email");

	if (!departureSelect) return;

	// Cập nhật giá khi chọn lịch khởi hành
	departureSelect.addEventListener("change", function () {
		updateQuantityLimit();
		updateMovingPrice();
		updateTourCost();
		validateBookingForm();
	});

	// Cập nhật tổng phí khi thay đổi số lượng
	if (quantityInput) {
		quantityInput.addEventListener("input", function () {
			updateQuantityLimit();
			updateMovingPrice();
			updateTourCost();
			validateBookingForm();
		});
	}

	// Validate khi nhập các trường liên lạc
	if (nameInput) nameInput.addEventListener("input", validateBookingForm);
	if (phoneInput) phoneInput.addEventListener("input", validateBookingForm);
	if (emailInput) emailInput.addEventListener("input", validateBookingForm);

	// Khởi tạo lần đầu
	updateMovingPrice();
	updateTourCost();
	validateBookingForm();
});
