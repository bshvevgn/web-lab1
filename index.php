<?php
session_start();

function checkPointInSquare($x, $y, $r)
{
    if ($x >= 0 && $x <= $r && $y >= 0 && $y <= $r) {
        return true;
    }
    return false;
}

function checkPointInArea($x, $y, $r)
{
    if ($x <= 0 && $y <= 0) {
        if ($x <= $r && $y <= $r) {
            if ($x * $x + $y * $y <= $r * $r) {
                return true;
            }
        }
    }
    return false;
}

function checkPointInTriangle($x, $y, $r)
{
    if ($x <= 0 && $y >= 0 && $y <= ($x / 2 + $r / 2)) {
        return true;
    }
    return false;
}


function checkPoint($x, $y, $r)
{
    return (checkPointInSquare($x, $y, $r) || checkPointInArea($x, $y, $r) || checkPointInTriangle($x, $y, $r));
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["x"]) && isset($_GET["y"]) && isset($_GET["r"])) {
    $x = floatval($_GET["x"]);
    $y = floatval($_GET["y"]);
    $r = floatval($_GET["r"]);

    if (is_numeric($x) && is_numeric($y) && is_numeric($r)) {
        $startTime = microtime(true);
        $result = checkPoint($x, $y, $r) ? "Попадает" : "Не попадает";
        $scriptTime = (microtime(true) - $startTime) * pow(10, 6);
        $_SESSION["results"][] = array("x" => $x, "y" => $y, "r" => $r, "result" => $result, "scriptTime" => $scriptTime, "time" => date("H:i:s"));
    }

}

if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
    $_SESSION['results'] = array();
    header('Location: index.php');
    exit();
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа #1</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link type="image/x-icon" href="icons/logo.ico" rel="shortcut icon">
    <link type="Image/x-icon" href="icons/logo.ico" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <div id="modalWindowBack" class="hiddenModalBack">
        <div class="modalWindow closedModalWindow" id="incorrectValueWindow">
            <div class="closeButton" id="incorrectValueWindowButton" onClick="closeModalWindow(this.id)"></div>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <p class="subtitle">Введено некорректное значение</p>
            </div>
            <p id="errorMessage"></p>
        </div>
        <div class="modalWindow closedModalWindow" id="areasWindow">
            <div class="closeButton" id="areasWindowButton" onClick="closeModalWindow(this.id)"></div>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <div class="verticalBox">
                    <p class="subtitle">Условие проверки</p>
                    <p>Факт попадания точки проверяется по данному графику.</p>
                    <div class="imageWrapper" style="background-image: url(images/areas.png)"></div>
                </div>
            </div>
            <p id="errorMessage"></p>
        </div>
        <div class="modalWindow closedModalWindow" id="clearTableWindow">
            <div class="closeButton" id="clearTableWindowButton" onClick="closeModalWindow(this.id)"></div>
            <div style="display: flex; flex-direction: row; align-items: center;">
                <p class="subtitle">Очистить результаты?</p>
            </div>
            <p>Вы действительно хотите очистить таблицу с результатами?</p>
            <div class="buttonsPanel">
                <div class="button deleteButton" onclick="clearTable()">
                    <p>Очистить</p>
                </div>
                <div class="button" id="clearTableWindowButton" onClick="closeModalWindow(this.id)">
                    <p>Отмена</p>
                </div>
            </div>
        </div>
    </div>
    <div id="header" class="header">
        <div id="logo"></div>
        <div class="headerInfo">
            <a href="https://my.itmo.ru/persons/372796">
                <p>Башаримов Евгений Александрович</p>
            </a>
            <p>P3206</p>
            <p>Вариант #1612</p>
        </div>
    </div>
    <div class="contentWrapper">
        <div id="formWrapper">
            <form action="index.php" method="get">
                <div class="centered" style="margin-bottom: 20px;">
                    <div class="button" style="margin-right: 20px;" id="areasWindowButton"
                        onClick='showModalWindow("areas", "")'>
                        <div class="icon" style="background-image: url(icons/areas.png);"></div>
                        <p>Условие</p>
                    </div>
                    <div class="verticalBox">
                        <h1 style="margin: 0px;">Проверка точки</h1>
                        <p>Введите данные для проверки</p>
                    </div>
                </div>
                <div class="verticalBox">
                    <p class="label">Координата X</p>
                    <p class="label hint">Выберите один из вариантов</p>
                </div>
                <div class="row">
                    <div class="slidable">
                        <input type="checkbox" name="xCh" id="x1" class="checkbox custom-checkbox" value="-5"
                            onchange="checkAddress(this)">
                        <label for="x1">-5</label>
                        <input type="checkbox" name="xCh" id="x2" class="checkbox custom-checkbox" value="-4"
                            onchange="checkAddress(this)">
                        <label for="x2">-4</label>
                        <input type="checkbox" name="xCh" id="x3" class="checkbox custom-checkbox" value="-3"
                            onchange="checkAddress(this)">
                        <label for="x3">-3</label>
                        <input type="checkbox" name="xCh" id="x4" class="checkbox custom-checkbox" value="-2"
                            onchange="checkAddress(this)">
                        <label for="x4">-2</label>
                        <input type="checkbox" name="xCh" id="x5" class="checkbox custom-checkbox" value="-1"
                            onchange="checkAddress(this)">
                        <label for="x5">-1</label>
                        <input type="checkbox" name="xv" id="x6" class="checkbox custom-checkbox" value="0"
                            onchange="checkAddress(this)">
                        <label for="x6">0</label>
                        <input type="checkbox" name="xCh" id="x7" class="checkbox custom-checkbox" value="1"
                            onchange="checkAddress(this)">
                        <label for="x7">1</label>
                        <input type="checkbox" name="xCh" id="x8" class="checkbox custom-checkbox" value="2"
                            onchange="checkAddress(this)">
                        <label for="x8">2</label>
                        <input type="checkbox" name="xCh" id="x9" class="checkbox custom-checkbox" value="3"
                            onchange="checkAddress(this)">
                        <label for="x9">3</label>
                    </div>
                    <input type="hidden" name="x" id="x" value="">
                </div>


                <br>
                <div class="verticalBox">
                    <p class="label">Координата Y</p>
                    <p class="label hint">Введите значение от -3 до 3</p>
                </div>
                <div class="inputWrapper">
                    <input class="textInput" type="text" id="y" name="y"
                        oninvalid='showModalWindow("incorrectValue", "Введено некорректное значение Y.");'>
                </div>
                <br>
                <div class="verticalBox">
                    <p class="label">Значение R</p>
                    <p class="label hint">Выберите один из вариантов</p>
                </div>
                <div class="row">
                    <div class="slidable" id="buttonsContainer">
                        <div class="button"><input type="button" onclick="rUpdate(1);" value="">
                            <p>1</p>
                        </div>
                        <div class="button"><input type="button" onclick="rUpdate(1.5);" value="">
                            <p>1.5</p>
                        </div>
                        <div class="button"><input type="button" onclick="rUpdate(2);" value="">
                            <p>2</p>
                        </div>
                        <div class="button"><input type="button" onclick="rUpdate(2.5);" value="">
                            <p>2.5</p>
                        </div>
                        <div class="button"><input type="button" onclick="rUpdate(3);" value="">
                            <p>3</p>
                        </div>
                        <div class="slidableBoxShadow"></div>
                    </div>
                    <div class="numberBox" style="margin-right: 20px">
                        <p id="rVal">- -</p>
                    </div>
                </div>
                <input type="hidden" id="r" name="r" value="">
                <br>
                <div class="button"><input type="submit" value="">
                    <div class="icon" style="background-image: url(icons/arrow.png);"></div>
                    <p>Проверить</p>
                </div>
            </form>
        </div>
        <div id="tableBox">
            <h1>Таблица результатов</h1>
            <div id="emptyTableMessage">
                <p>Таблица пуста</p>
            </div>
            <div class="tableWrapper">
                <table class="border-none fixedHead" id="resultsTable">
                    <thead>
                        <tr>
                            <th>X</th>
                            <th>Y</th>
                            <th>R</th>
                            <th>Результат</th>
                            <th>Время выполнения, мс</th>
                            <th>Время</th>
                        </tr>
                    </thead>
                    <?php
                    if (isset($_SESSION["results"])) {
                        foreach ($_SESSION["results"] as $result) {
                            echo "<tr>";
                            echo "<td>{$result["x"]}</td>";
                            echo "<td>{$result["y"]}</td>";
                            echo "<td>{$result["r"]}</td>";
                            echo "<td>{$result["result"]}</td>";
                            echo "<td>{$result["scriptTime"]}</td>";
                            echo "<td>{$result["time"]}</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
            <div class="button inactiveButton" id="clearButton" onclick='showModalWindow("clearTable", "")'>
                <div class="icon" style="background-image: url(icons/trash.png);"></div>
                <p>Очистить результаты</p>
            </div>
            <script>
                const table = document.getElementById('resultsTable');
                const rows = table.getElementsByTagName('tr');

                if (rows.length > 1) {
                    document.getElementById("clearButton").classList.remove("inactiveButton");
                    document.getElementById("emptyTableMessage").style.display = "none";
                    document.getElementById("resultsTable").style.display = "block";
                } else {
                    document.getElementById("clearButton").classList.add("inactiveButton");
                    document.getElementById("emptyTableMessage").style.display = "block";
                    document.getElementById("resultsTable").style.display = "none";
                }
            </script>
        </div>
        <!--<div class="imageWrapper" style="background-image: url(images/areas.png);"></div>-->
        <div id="timeBox">
            <div class="icon" style="background-image: url(icons/clock.png);"></div>
            <p id="currentTime">
                <?php echo date('H:i:s'); ?>
            </p>
        </div>
        <script>
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
                document.getElementById(ID.substring(0, ID.length - 6)).classList.add('closedModalWindow');
                document.getElementById("modalWindowBack").classList.add("hiddenModalBack");
            }

            function showModalWindow(ID, message) {
                $('#errorMessage').html(message);
                document.getElementById(ID + "Window").classList.remove('closedModalWindow');
                document.getElementById("modalWindowBack").classList.remove("hiddenModalBack");
            }

            document.querySelector("form").addEventListener("submit", function (event) {
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
                window.location.href = 'index.php?clear=true';
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


            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }

            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('currentTime').innerHTML = h + ":" + m + ":" + s;
                t = setTimeout(function () {
                    startTime()
                }, 500);
            }

            startTime();


        </script>
    </div>
    <style>
        body {
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        #logo {
            height: 100%;
            width: 70px;
            float: left;
            background-image: url(icons/logo.png);
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }

        .contentWrapper {
            min-width: calc(100vw - 60px);
            min-height: calc(100vh - 160px);
            height: fit-content;
            background-color: rgb(241, 241, 241);
            padding: 130px 30px 30px 30px;
            float: left;
        }

        .header {
            height: 70px;
            width: calc(100vw - 60px);
            position: fixed;
            top: 30px;
            left: 30px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            -moz-backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            z-index: 1000;
            transition: .3s;
        }

        .headerInfo {
            display: flex;
            height: 100%;
            width: max-content;
            align-items: center;
            margin-left: auto;
            order: 2;
            padding-right: 20px;
        }

        .headerInfo p {
            margin: 0px 0px 0px 16px;
            font-family: 'Manrope', sans-serif;
            font-size: 16px;
            color: black;
            transition: .2s;
        }

        .headerInfo p:hover {
            color: #ED0A42;
        }

        .label {
            margin: 10px 0px;
        }

        #timeBox {
            background: white;
            border-radius: 16px;
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: fit-content;
            height: fit-content;
            padding: 12px 18px;
            display: flex;
            flex-direction: row;
            align-items: center;
            filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.1));
            -webkit-filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.1));
        }

        #timeBox .icon {
            margin-right: 10px;
        }

        .buttonsPanel {
            bottom: 0px;
            left: 0px;
            height: fit-content;
            width: 100%;
            display: flex;
            flex-direction: row;
            padding: 30px 0px 0px 0px;
        }

        .buttonsPanel .button {
            margin: 0px 20px 0px 0px !important;
            background-color: rgb(225, 225, 225);
        }

        .buttonsPanel :last-child {
            margin: 0px !important;
        }

        .deleteButton {
            background-color: #ED0A42 !important;
        }

        .deleteButton p {
            color: white;
        }

        #tableBox .button {
            margin-top: 20px;
        }

        #tableBox {
            display: flex;
            flex-direction: column;
        }

        table {
            border-collapse: collapse;
        }

        #formWrapper {
            width: max-content;
            height: fit-content;
            float: left;
            padding-right: 60px;
        }

        .tableWrapper {
            width: fit-content;
            border-radius: 16px;
            float: left;
            max-height: 400px;
            overflow-y: scroll;
            background-color: white;
            position: relative;
        }

        .fixedHead {
            table-layout: fixed;
            border-collapse: collapse;
        }

        .fixedHead thead {
            background-color: #1f1f1f;
            color: #FDFDFD;
            position: fixed;
            top: 0px;
            left: 0px;
            position: sticky;
        }

        #emptyTableMessage {
            background-color: #1f1f1f;
            color: #FDFDFD;
            width: fit-content;
            padding: 14px 18px;
            border-radius: 16px;
        }

        .verticalBox {
            display: flex;
            flex-direction: column;
            width: max-content;
        }

        .verticalBox h1 {
            margin-bottom: 0px;
        }

        th,
        td {
            padding: 14px 18px;
            font-family: 'Manrope', sans-serif;
            font-size: 18px;
        }

        .border-none {
            border-collapse: collapse;
            border: none;
        }

        .border-none td {
            border: 1px solid rgb(0 0 0 / 20%);
        }

        .border-none tr:first-child td {
            border-top: none;
        }

        .border-none tr:last-child td {
            border-bottom: none;
        }

        .border-none tr td:first-child {
            border-left: none;
        }

        .border-none tr td:last-child {
            border-right: none;
        }

        tbody {
            background-color: white;
        }

        .button {
            padding: 16px 22px;
            border-radius: 16px;
            background: white;
            overflow: hidden;
            position: relative;
            width: fit-content;
            margin-bottom: 20px;
            cursor: pointer;
            transform: scale(1);
            transition: .1s;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;

        }

        .button .icon {
            height: 30px;
            width: 30px;
            margin-right: 12px;
        }

        .button:active {
            transform: scale(0.94);
        }

        .closeButton:active {
            transform: scale(0.9);
        }

        .icon {
            height: 20px;
            width: 20px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .button input {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .inactiveButton {
            filter: grayscale(1);
            opacity: 0.4;
            touch-action: none;
            pointer-events: none;
        }

        .numberBox {
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            min-width: fit-content;
            padding: 6px 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30px;
            width: 44px;
        }

        .closedModalWindow {
            touch-action: none;
            overflow: hidden !important;
            transform: translate(-50%, -50%) scale(1.2) !important;
            max-height: 0 !important;
            opacity: 0 !important;
            padding: 0 !important;
            transition: max-height 0ms 400ms, padding 0ms 400ms, opacity 400ms 0ms, transform 300ms 0ms !important;
        }

        .modalWindow {
            transition: height 0ms 0ms, opacity 300ms 0ms, transform 300ms 0ms;
            opacity: 1;
            transform: scale(1) translate(-50%, -50%);
            z-index: 100;
            position: absolute;
            display: flex;
            flex-direction: column;
            top: 50%;
            left: 50%;
            background-color: rgba(255, 255, 255, .8);
            padding: 30px;
            overflow: hidden;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            max-height: 800px;
            border-radius: 28px;
        }

        .modalWindow .subtitle {
            margin-right: 100px;
        }

        .modalWindow .imageWrapper {
            opacity: .9;
        }

        .closeButton {
            height: 34px;
            width: 34px;
            position: absolute;
            top: 30px;
            right: 30px;
            background-image: url(icons/close.png);
            background-size: cover;
            cursor: pointer;
            z-index: 10;
            transition: .2s;
        }

        #modalWindowBack {
            transition: height 0ms 0ms, opacity 300ms 0ms;
            z-index: 99;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background-color: rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100vw;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1001;
            opacity: 1
        }

        .hiddenModalBack {
            height: 1px !important;
            top: -1px !important;
            opacity: 0 !important;
            transition: height 0ms 400ms, opacity 400ms 0ms !important
        }

        .subtitle,
        p,
        label {
            font-family: 'Manrope', sans-serif;
            margin: 0px;
            font-size: 18px;
        }

        label {
            margin-right: 14px;
        }

        h1 {
            font-family: 'Manrope', sans-serif;
            font-size: 32px;
        }

        .hint {
            margin-top: -8px;
            font-size: 14px;
        }

        .subtitle {
            font-size: 30px;
            margin-bottom: 4px;
            font-weight: 800;
        }

        input {
            border: none;
            outline: none !important;
            background: transparent;
        }

        .inputWrapper {
            display: flex;
            flex-direction: row;
            align-items: center;
            width: fit-content;
            transition: .2s;
            border-radius: 16px;
            overflow: hidden;
            background-color: white;
            border: 1px solid white;
        }

        .centered {
            display: flex;
            width: max-content;
            height: fit-content;
            justify-content: center;
        }

        .centered .button {
            margin-bottom: 0px;
        }

        .row,
        .slidable {
            height: fit-content;
            width: fit-content;
            background-color: white;
            border-radius: 16px;
            display: flex;
            flex-direction: row;
        }

        .slidable {
            overflow-x: scroll;
            width: max-content;
            padding: 0px 20px 0px 20px;
            border-radius: 0px 10px 10px 0px;
            position: relative;
            padding: 20px;
        }

        .slidable :last-child {
            margin-right: 0px;
        }

        .slidableBoxShadow {
            background: linear-gradient(270deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%);
            height: 100%;
            width: 30px;
            top: 0px;
            right: 0px;
        }

        .row .button {
            margin: 0px 14px 0px 0px;
            background-color: rgb(241, 241, 241);
            border-radius: 10px;
            padding: 10px 20px;
        }

        .row .button:hover {
            background-color: rgb(236, 236, 236);
        }

        #buttonsContainer {
            width: calc(100% - 64px);
        }

        .inputWrapper:has(.valid:focus) {
            background-color: #dffff1;
            border: 1px solid #dffff1;
        }

        .inputWrapper:has(.invalid:focus) {
            background-color: #ffedf1;
            border: 1px solid #ffedf1;
        }

        .inputWrapper:has(.invalid) {
            border: 1px solid #ED0A42;
        }

        .textInput {
            padding: 20px;
            font-size: 18px;
            font-family: 'Manrope', sans-serif;
            border: none;
            transition: .2s
        }

        .custom-checkbox {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .custom-checkbox+label {
            display: inline-flex;
            align-items: center;
            user-select: none;
        }

        .row {
            align-items: center;
            overflow: hidden;
        }

        .custom-checkbox+label::before {
            content: '';
            display: inline-block;
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            flex-grow: 0;
            transition: .10s;
            border: 1px solid #adb5bd;
            border-radius: 0.25em;
            margin-right: 0.5em;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 50% 50%;
        }


        .custom-checkbox:not(:disabled):not(:checked)+label:hover::before {
            border-color: #b3d7ff;
        }

        .custom-checkbox:not(:disabled):active+label::before {
            background-color: #b3d7ff;
            border-color: #b3d7ff;
            transform: scale(0.9);
        }

        .custom-checkbox:focus+label::before {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .custom-checkbox:focus:not(:checked)+label::before {
            border-color: #80bdff;
        }

        .custom-checkbox:checked+label::before {
            border-color: #0b76ef;
            background-color: #0b76ef;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
        }

        .custom-checkbox:disabled+label::before {
            background-color: #e9ecef;
        }

        .imageWrapper {
            width: 260px;
            height: 260px;
            background-position: center;
            background-size: 100%;
            background-repeat: no-repeat;
            border-radius: 16px;
        }

        .modalWindow .imageWrapper {
            margin-top: 20px;
        }

        .blurred {
            filter: blur(6px);
            opacity: 0.2;
            transform: scale(0.5);
            transition: filter 100ms 0ms, opacity 50ms 50ms, transform 100ms 0ms;
        }

        #rVal {
            transition: filter 100ms 0ms, opacity 100ms 0ms, transform 100ms 0ms;
        }

        #currentTime {
            width: 75px;
        }

        @media screen and (max-width: 1000px) {
            .wideHeader {
                transition: .3s;
                width: 100%;
                top: 0px;
                left: 0px;
                border-radius: 0px;
            }

            #formWrapper,
            #tableBox {
                width: 100%;
                float: left;
                padding-right: 0px;
            }

            .contentWrapper {
                width: calc(100% - 60px);
            }

            .centered {
                flex-direction: column;
            }

            .headerInfo {
                display: none;
            }

            .row {
                height: fit-content;
                width: auto;
                background-color: white;
                border-radius: 16px;
                display: flex;
                flex-direction: row;
                overflow: scroll;
                align-items: center;
            }

            .slidable {
                overflow-x: scroll;
                width: max-content;
                padding: 20px;
                border-radius: 0px 10px 10px 0px;
                position: relative;
            }

            #buttonsContainer{
                padding: 0px 10px 0px 20px;
                border-radius: 0px 10px 10px 0px;
                position: relative;
                margin-top: 20px;
                margin-bottom: 20px;
                margin-right: 10px;
            }

            .modalWindow {
                max-width: calc(90vw - 80px);
            }

            .subtitle,
            h1 {
                font-size: 30px;
                margin-bottom: 4px;
                font-weight: 800;
                line-height: 30px;
                margin-bottom: 14px;
            }

            #areasWindowButton {
                margin-bottom: 20px;
            }

            .tableWrapper {
                width: auto;
                border-radius: 16px;
                float: left;
                max-height: 400px;
                overflow-y: scroll;
                background-color: white;
                overflow-x: scroll;
            }

            .buttonsPanel :last-child {
                margin: 0px !important;
            }

            .buttonsPanel .button {
                width: calc(50% - 15px);
            }

            .contentWrapper {
                padding: 130px 30px 90px 30px;
            }

        }
    </style>
</body>

</html>