fetch("header.php")
.then(res => res.text())
.then(data => document.getElementById("header-placeholder").innerHTML = data);