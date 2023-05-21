const infoShow = document.querySelector(".personal_info");
const accountShow = document.querySelector(".account");
const notificationShow = document.querySelector(".notifications");

const c_user = document.querySelector("#change_username").querySelector("button");
const n_user = document.querySelector("#new_username");
const n_user_btn = document.querySelector("#new_username").querySelector("button");

c_user.addEventListener('click', function() {
    c_user.classList.remove("show");
    c_user.classList.add("hide");
    n_user.classList.remove("hide");
    n_user.classList.add("show");
})

n_user_btn.addEventListener('click', function() {
    n_user.classList.remove("show");
    n_user.classList.add("hide");
    c_user.classList.remove("hide");
    c_user.classList.add("show");
})

const selections = document.querySelector(".selections").querySelectorAll("a");

selections.forEach(element => {
    element.addEventListener('click', function() {
        selections.forEach(nav => nav.classList.remove("active"));
        this.classList.add("active");
    })
});

function piShow() {
    infoShow.style.display = "block";
    accountShow.style.display = "none";
    notificationShow.style.display = "none";
}

function accShow() {
    infoShow.style.display = "none";
    accountShow.style.display = "block";
    notificationShow.style.display = "none";
}

function notifShow() {
    infoShow.style.display = "none";
    accountShow.style.display = "none";
    notificationShow.style.display = "block";
}

const notif_active = document.querySelector('.notif_active');
const notif_disabled = document.querySelector('.notif_disabled');
const disable = document.querySelectorAll('.dependent')

notif_disabled.addEventListener('click', function() {
    disable.forEach(option => option.disabled = true);
})

notif_active.addEventListener('click', function() {
    disable.forEach(option => option.disabled = false);
})
