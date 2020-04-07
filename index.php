<?php

function loadRegistrations($filename)
{
    $jsonData = file_get_contents($filename);
    $arrData = json_decode($jsonData, true);
    return $arrData;
}

function saveDataJSON($filename, $name, $email, $phone)
{
    try {
        $concat = ["name" => $name, "email" => $email, "phone" => $phone];

        //json to array
        $arr_data = loadRegistrations($filename);
        //push to array
        array_push($arr_data, $concat);
        //array to json
        $jsonData = json_encode($arr_data, JSON_PRETTY_PRINT);
        //write to json file
        file_put_contents($filename, $jsonData);
        echo "Successful";
    } catch (Exception $e) {
        echo "Error!", $e->getMessage(), "\n";
    }
}

$nameErr = null;
$emailErr = null;
$phoneErr = null;
$email = null;
$name = null;
$phone = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $error = false;
}
if (empty($name)) {
    $nameErr = "Name empty!";
    $error = true;
}
if (empty($email)) {
    $emailErr = "Email empty!";
    $error = true;
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Email not Validate!(xxx@xxx.xxx.xxx)";
    $error = true;
}
if (empty($phone)) {
    $phoneErr = "Phone Number Empty!";
    $error = true;
}
if ($error === false) {
    saveDataJSON("users.json", $name, $email, $phone);
    $name = null;
    $email = null;
    $phone = null;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tang dang ki nguoi dung</title>
</head>
<body>
<form action="" method="post">
    Ten nguoi dung: <input type="text" name="name" value="<?php echo $name; ?>">
    <span><?php echo $nameErr; ?></span>
    <br><br>
    Email: <input type="text" name="email" value="<?php echo $email; ?>">
    <span><?php echo $emailErr; ?></span>
    <br><br>
    Dien thoai: <input type="text" name="phone" value="<?php $phone ?>">
    <span><?php echo $phoneErr; ?></span>
    <br><br>
    <input type="submit" value="Send" name="submit">


</form>

<?php $registrations = loadRegistrations("users.json"); ?>
<h2>Form dang ki</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>
    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td><?php echo $registration['name'];?></td>
            <td><?php echo $registration['email'];?></td>
            <td><?php echo $registration['phone'];?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
