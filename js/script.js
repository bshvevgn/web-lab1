function checkTable() {
    const table = document.getElementById('resultsTable');
    const rows = table.getElementsByTagName('tr');

    $('#resultsTable').addClass('updating');

    if (rows.length > 1) {
        document.getElementById("clearButton").classList.remove("inactiveButton");
        document.getElementById("emptyTableMessage").style.display = "none";
        document.getElementById("resultsTable").style.display = "block";
    } else {
        document.getElementById("clearButton").classList.add("inactiveButton");
        document.getElementById("emptyTableMessage").style.display = "block";
        document.getElementById("resultsTable").style.display = "none";
    }

    setTimeout(() => $('#resultsTable').removeClass('updating'), 400);
    
}

function scrollDown(element){
    element.scrollTop = element.scrollHeight;
}

document.addEventListener("DOMContentLoaded", (event) => {
    sendData("");
    checkTable();
});

function sendData(dataForSend) {
    $.ajax({
        type: 'GET',
        url: 'php/session.php',
        data: dataForSend,
        success: (response) => {
            console.log(response);
            $('#resultsContainer').html(response);
            scrollDown(document.getElementById("resultsTable"))
            checkTable();
        },
        error: (error) => {
            console.log(error);
            setTip("Server response error");
        }
    });
}

$(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll > 20) {
        $('#header').addClass('wideHeader');
    } else {
        $('#header').removeClass('wideHeader');
    }
}

);

function closeModalWindow(ID) {
    document.getElementById(ID).classList.add('closedModalWindow');
    document.getElementById("modalWindowBack").classList.add("hiddenModalBack");
}

function showModalWindow(ID, message) {
    $('.errorMessage').html(message);
    document.getElementById(ID + "Window").classList.remove('closedModalWindow');
    document.getElementById("modalWindowBack").classList.remove("hiddenModalBack");
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault();

    var xInput = document.getElementById("x");
    var yInput = document.getElementById("y");
    var rInput = document.getElementById("r");


    /*if (xInput.value == '' && yInput.value == '' && zInput.value == '') {
        event.preventDefault();
        showModalWindow("incorrectValue", "Пожалуйста, введите необходимые значения.");
    }*/

    if (xInput == null) {
        event.preventDefault();
        showModalWindow("incorrectValue", "Пожалуйста, выберите значение для X.");
    } else if (parseFloat(yInput.value) > 3 || parseFloat(yInput.value) < -3) {
        event.preventDefault();
        showModalWindow("incorrectValue", "Пожалуйста, введите значение для Y от -3 до 3.");
    } else if (rInput == "") {
        event.preventDefault();
        showModalWindow("incorrectValue", "Пожалуйста, выберите значение для R.");
    } else if (!isValid(xInput.value) || !isValid(yInput.value) || (!isValid(rInput.value) && !isPositive(rInput.value))) {
        event.preventDefault();
        showModalWindow("incorrectValue", "Проверьте введённые данные.");
    } else {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        h = checkTime(h);
        m = checkTime(m);
        s = checkTime(s);
        var currentTime = h + ":" + m + ":" + s;
        var dataForSend = "x=" + xInput.value + "&y=" + yInput.value + "&r=" + rInput.value + "&time=" + currentTime;
        sendData(dataForSend);
        document.getElementById("clearButton").classList.remove("inactiveButton");
    }
});

function isValid(value) {
    return !isNaN(parseFloat(value)) && isFinite(value) && value != null;
}

function isPositive(value) {
    return (value > 0);
}

function clearTable() {
    sendData("clear=true");
}

function checkAddress(checkbox) {
    if (checkbox.checked == true) {
        var checkboxes = document.getElementsByClassName('checkbox');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
            document.getElementById('x').value = "";
        }
        checkbox.checked = true;
        document.getElementById('x').value = checkbox.value;
    }

    if (checkbox.checked == false) {
        document.getElementById('x').value = "";
    }
}

function unblurNumber() {
    $('#rVal').removeClass('blurred');
}

function rUpdate(value) {
    document.getElementById('r').value = value;
    $('#rVal').addClass('blurred');
    setTimeout(() => $('#rVal').html(value), 100);
    setTimeout(() => $('#rVal').removeClass('blurred'), 200);
}

const input = document.querySelector('#y');

input.addEventListener('input', function () {
    const value = input.value;

    if (!value) {
        input.classList.remove('valid', 'invalid');
    } else if (isNaN(+(value))) {
        input.classList.add('invalid');
        input.classList.remove('valid');
    } else if (+(value) >= -3 && +(value) <= 3) {
        input.classList.add('valid');
        input.classList.remove('invalid');
    } else {
        input.classList.add('invalid');
        input.classList.remove('valid');
    }
});

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('currentTime').innerHTML = h + ":" + m + ":" + s;
    t = setTimeout(function () {
        startTime()
    }, 500);
}

startTime();