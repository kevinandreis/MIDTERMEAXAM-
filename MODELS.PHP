<?php
session_start();
require_once 'dbConfig.php';


function registerUser($pdo, $username, $password) {
  
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
       
        return $stmt->execute([$username, $hashedPassword]);
    } catch (PDOException $e) {
        
        error_log("Error: " . $e->getMessage());
        return false; 
    }

function authenticateUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}


function logoutUser() {
    session_unset();
    session_destroy();
}


function seeAllCars($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM car");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addCar($pdo, $make, $model, $year, $license_plate) {
    $stmt = $pdo->prepare("INSERT INTO car (make, model, year, license_plate) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$make, $model, $year, $license_plate]);
}

function getCarById($pdo, $car_id) {
    $stmt = $pdo->prepare("SELECT * FROM car WHERE car_id = ?");
    $stmt->execute([$car_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteCar($pdo, $car_id) {
    $stmt = $pdo->prepare("DELETE FROM car WHERE car_id = ?");
    return $stmt->execute([$car_id]);
}

function updateCar($pdo, $car_id, $make, $model, $year, $license_plate) {
    $stmt = $pdo->prepare("UPDATE car SET make = ?, model = ?, year = ?, license_plate = ? WHERE car_id = ?");
    return $stmt->execute([$make, $model, $year, $license_plate, $car_id]);
}
?>
