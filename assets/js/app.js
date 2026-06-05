document.addEventListener("DOMContentLoaded", function () {
  const payAmountInput = document.getElementById("pay_amount");
  const totalPriceInput = document.getElementById("total_price");
  const changeAmountDisplay = document.getElementById("change_amount_display");

  if (payAmountInput && totalPriceInput && changeAmountDisplay) {
    payAmountInput.addEventListener("input", function () {
      const totalPrice = parseInt(totalPriceInput.value) || 0;
      const payAmount = parseInt(payAmountInput.value) || 0;
      const changeAmount = payAmount - totalPrice;

      if (changeAmount >= 0) {
        changeAmountDisplay.value = "Rp " + changeAmount.toLocaleString("id-ID");
      } else {
        changeAmountDisplay.value = "Rp 0";
      }
    });
  }

  const deleteButtons = document.querySelectorAll(".btn-delete");
  deleteButtons.forEach(function (button) {
    button.addEventListener("click", function (e) {
      if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        e.preventDefault();
      }
    });
  });
});
