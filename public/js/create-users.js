// window.onload = function () {
//     alert("et");
// };

// alert("asd")
const role = document.getElementById("role");
const salesManager = document.getElementById("manager");
role.onchange = function (params) {
    if (this.value == "sales") {
        salesManager.style.display = "block";
    } else {
        salesManager.style.display = "none";
    }
};

const showPasswords = document.getElementsByClassName("show-password");
for (var i = 0; i < showPasswords.length; i++) {
    showPasswords[i].onclick = (e) => {
        e.preventDefault();
        const input = document.getElementById(
            e.target.getAttribute("data-show-password")
        );
        input.type == "text"
            ? (input.type = "password")
            : (input.type = "text");
    };
}

 