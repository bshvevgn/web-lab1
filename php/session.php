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

function checkY($y)
{
    if (!$y) {
        return false;
    } else if (is_nan($y)) {
        return false;
    } else if ($y >= -3 && $y <= 3) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["x"]) && isset($_GET["y"]) && isset($_GET["r"])) {
    $x = floatval($_GET["x"]);
    $y = floatval($_GET["y"]);
    $r = floatval($_GET["r"]);
    $time = $_GET["time"];
    if (is_numeric($x) && is_numeric($y) && is_numeric($r)) {
        if (checkY($y)) {
            $startTime = microtime(true);
            $result = checkPoint($x, $y, $r) ? "Попадает" : "Не попадает";
            $scriptTime = (microtime(true) - $startTime) * pow(10, 6);
            $_SESSION["results"][] = array("x" => $x, "y" => $y, "r" => $r, "result" => $result, "scriptTime" => $scriptTime, "time" => $time);
        }
    }
}

if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
    $_SESSION['results'] = array();
}

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
?>