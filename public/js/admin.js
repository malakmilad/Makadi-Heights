var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})


const inputs = document.getElementsByTagName("input");
const selects = document.getElementsByTagName("select");
const textareas = document.getElementsByTagName("textarea");
const btns = document.getElementById("buttons-to-top");
const btns_location = btns ? btns.offsetTop : null;

var links = document.querySelectorAll("li.menu-link");
var current = location.pathname;

links.forEach(function (element) {
    if (element.getAttribute("href").indexOf(current) !== -1) {
        element.classList.remove("active");
        element.classList.add("active");
    }
});

var select_all_checkboxes = document.querySelectorAll(".select-all");
for (let index = 0; index < select_all_checkboxes.length; index++) {
    const element = select_all_checkboxes[index];
    element.onchange = function (e) {
        e.preventDefault();
        const checkboxes = document.querySelectorAll(
            "#" + this.getAttribute("target") + " input"
        );
        if (this.checked) {
            for (let j = 0; j < checkboxes.length; j++) {
                const checkbox = checkboxes[j];
                checkbox.checked = true;
            }
        } else {
            for (let j = 0; j < checkboxes.length; j++) {
                const checkbox = checkboxes[j];
                checkbox.checked = false;
            }
        }
    };
    // console.log(element.getAttribute('target'));
}
// console.log(select_all_checkboxes);

// function buttonsToTop() {
//     if (window.pageYOffset > btns_location) {
//         btns.classList.add("to-header");
//     } else if (window.pageYOffset < btns_location) {
//         btns.classList.remove("to-header");
//     }
// }

function openSave(inputs, selects) {
    for (let index = 0; index < inputs.length; index++) {
        const input = inputs[index];
        input.addEventListener("change", function () {
            document.getElementById("save-button").disabled = false;
            document.getElementById("save-button-mobile").disabled = false;
        });
    }
    for (let j = 0; j < selects.length; j++) {
        const select = selects[j];
        select.addEventListener("change", function () {
            document.getElementById("save-button").disabled = false;
            document.getElementById("save-button-mobile").disabled = false;
        });
    }
    for (let x = 0; x < textareas.length; x++) {
        const textarea = textareas[x];
        textarea.addEventListener("change", function () {
            document.getElementById("save-button").disabled = false;
            document.getElementById("save-button-mobile").disabled = false;
        });
    }
}

window.onload = function () {
    const loader = document.getElementById("loader");
    loader.style.display = "none";

    var tds = document.getElementsByClassName("go-to-location");

    for (var i = 0; i < tds.length; i++) {
        var td = tds[i];
        let location = td.parentElement.getAttribute("location");
        td.onclick = function () {
            window.location = location;
        };
    }

    openSave(inputs, selects);
    // let save_btn = save_btn;
};

window.onscroll = function () {
    // if (btns) {
    //     buttonsToTop();
    // }
};

// menu-Mobile
var querySelector = document.querySelector.bind(document);
var nav = document.querySelector(".menu-Mobile");
querySelector(".toggle_menu").onclick = function () {
    nav.classList.toggle("mobile_menu__opened");
    // wrapper.classList.toggle('toggle-content');
};

window.addEventListener('mouseup', function(e) {
    if (e.target != document.querySelector(".menu-Mobile")) {
        nav.classList.remove("mobile_menu__opened");
    }
});
