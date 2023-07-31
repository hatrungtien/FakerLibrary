<?php
require_once 'vendor/autoload.php';

use Faker\Factory;

// Tạo một đối tượng Faker
$faker = Factory::create();

// Kết nối đến CSDL của bạn (chúng ta giả định rằng bạn đã có CSDL và kết nối đến nó)

// Ví dụ: Kết nối đến CSDL MySQL
$servername = "localhost";
$username = "";
$password = "root";
$dbname = "facebookclone";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";

    // Sinh dữ liệu giả cho bảng người dùng (user table)
    $userInsertQuery = "INSERT INTO users (name, email, address, phone) VALUES (:name, :email, :address, :phone)";
    $userStmt = $conn->prepare($userInsertQuery);

    for ($i = 0; $i < 10; $i++) {
        $name = $faker->name;
        $email = $faker->email;
        $address = $faker->address;
        $phone = $faker->phoneNumber;

        $userStmt->bindParam(':name', $name);
        $userStmt->bindParam(':email', $email);
        $userStmt->bindParam(':address', $address);
        $userStmt->bindParam(':phone', $phone);

        $userStmt->execute();
        echo "User record inserted: $name, $email, $address, $phone\n";
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
