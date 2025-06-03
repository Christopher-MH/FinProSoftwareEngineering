fetch("header.php")
.then(res => res.text())
.then(data => document.getElementById("header-placeholder").innerHTML = data);

// document.querySelectorAll("form").forEach(form => {
//     form.addEventListener("submit", function(e) {
//         const confirmed = confirm("Apakah Anda yakin ingin redeem voucher ini?");
//         if (!confirmed) e.preventDefault();
//     });
// });