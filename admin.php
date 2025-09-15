<?php
session_start();


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $year = $_POST['year'] ?? '';
    $engine = $_POST['engine'] ?? '';
    $power = $_POST['power'] ?? '';
    $fuel = $_POST['fuel'] ?? '';
    $transmission = $_POST['transmission'] ?? '';
    $price = $_POST['price'] ?? '';
    $image = $_FILES['image'] ?? null;

 
    if ($image && $image['error'] === 0) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($ext), $allowed)) {
            $newName = 'images/' . time() . '_' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $newName);
        } else {
            $newName = '';
        }
    } else {
        $newName = '';
    }

  
    $newCar = [
        'name' => $name,
        'year' => $year,
        'engine' => $engine,
        'power' => $power,
        'fuel' => $fuel,
        'transmission' => $transmission,
        'price' => $price,
        'image' => $newName,
    ];


    $dataFile = 'uploads/data.json';
    if (file_exists($dataFile)) {
        $jsonData = file_get_contents($dataFile);
        $cars = json_decode($jsonData, true);
        if (!$cars) $cars = [];
    } else {
        $cars = [];
    }
    $cars[] = $newCar;


file_put_contents($dataFile, json_encode($cars, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));



    $success = "Araç başarıyla eklendi!";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Admin Paneli - Araç Ekle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f3f6;
            margin: 0;
            padding: 40px;
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #1a242f;
        }

        p {
            margin-top: 20px;
        }

        p a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }

        .success {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Admin Paneli - Araç Ekle</h1>

<?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>

<form method="post" enctype="multipart/form-data">
    <label>Adı:
        <input type="text" name="name" required />
    </label>

    <label>Yıl:
        <input type="number" name="year" required />
    </label>

    <label>Motor:
        <input type="text" name="engine" required />
    </label>

    <label>Güç:
        <input type="text" name="power" required />
    </label>

    <label>Yakıt Türü:
        <input type="text" name="fuel" required />
    </label>

    <label>Şanzıman:
        <input type="text" name="transmission" required />
    </label>

    <label>Fiyat:
        <input type="text" name="price" required />
    </label>

    <label>Fotoğraf:
        <input type="file" name="image" accept="image/*" required />
    </label>

    <button type="submit">Araç Ekle</button>
</form>

<p><a href="index.php">Ana Sayfaya Dön</a></p>
<p><a href="logout.php">Çıkış Yap</a></p>

</body>
</html>

