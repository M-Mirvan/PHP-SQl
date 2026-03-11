<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheek rotterdam";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$title = mysqli_real_escape_string($conn, $_POST['title']);
$author = mysqli_real_escape_string($conn, $_POST['author']);
$genre = mysqli_real_escape_string($conn, $_POST['genre']);
$published_year = mysqli_real_escape_string($conn, $_POST['published_year']);
$beoordeling = mysqli_real_escape_string($conn, $_POST['beoordeling']);
$is_available = mysqli_real_escape_string($conn, $_POST['availability']);

$sql = "INSERT INTO books 
(title, author, genre, published_year, beoordeling, is_available)
VALUES 
('$title','$author','$genre','$published_year','$beoordeling','$is_available')";

if ($conn->query($sql) === TRUE) {
    echo "Boek succesvol toegevoegd";
} else {
    echo "Error: " . $conn->error;
}

}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <br><a href="boeken.php">overzicht    </a><a href="boeken toe.php">   boeken toevoegen</a></br>
<title>boek toevoegen</title>
</head>
<body>

<h2>boek toevoegen</h2>

<form method="POST">



title:<br>
<input type="text" name="title" required>
<br><br>

author:<br>
<input type="text" name="author" required>
<br><br>

published_year:<br>
<input type="number" name="published_year" required min="0" max="9999">
<br><br>

beoordeling:<br>
<input type="radio" name="beoordeling" value="Bad" required>Bad<br>
<input type="radio" name="beoordeling" value="Mid">Mid<br>
<input type="radio" name="beoordeling" value="Good">Good<br>
<input type="radio" name="beoordeling" value="excellence">excellence<br><br>

genre:<br>
<input type="radio" name="genre" value="Fantasy" required> Fantasy<br>
<input type="radio" name="genre" value="Thriller"> Thriller<br>
<input type="radio" name="genre" value="Classic"> Classic<br>
<input type="radio" name="genre" value="Programming"> Programming<br><br>

availability:<br>
<input type="radio" name="availability" value="1" required> Available<br>
<input type="radio" name="availability" value="0"> Not Available<br><br>

<input type="submit" value="Opslaan">
</form>

</body>
</html>