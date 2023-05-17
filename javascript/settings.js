const popup = document.querySelector('.popup');
const openPop = document.querySelector('.open');
const closePop = document.querySelector('.close');
const yesDelete = document.querySelector('.delete');

openPop.addEventListener('click', () => {
    popup.showModal();
})

closePop.addEventListener('click', () => {
    popup.close();
})

yesDelete.addEventListener('click', () => {
    popup.close();
})

function hidenshow() {
    var change_username = document.getElementById("change_username");
    var new_username = document.getElementById("new_username");
    if(new_username.style.display === "none") {
        new_username.style.display = "block";
        change_username.style.display = "none";
    }
    else {
        new_username.style.display = "none";
        change_username.style.display = "block";
    }  
}

selections = document.querySelector(".selections").querySelectorAll("a");

selections.forEach(element => {
    element.addEventListener('click', function() {
        selections.forEach(nav => nav.classList.remove("active"));
        this.classList.add("active");
    })
});

infoShow = document.querySelector(".personal_info");
accountShow = document.querySelector(".account");
notificationShow = document.querySelector(".notifications");

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