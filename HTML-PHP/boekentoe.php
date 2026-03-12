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
    $rating = isset($_POST['rating']) ? mysqli_real_escape_string($conn, $_POST['rating']) : '';
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);

    $sql = "INSERT INTO books 
    (title, author, genre, published_year, rating, availability)
    VALUES 
    ('$title','$author','$genre','$published_year','$rating','$availability')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>Boek succesvol toegevoegd</p>";
    } else {
        echo "<p class='error-msg'>Error: " . $conn->error . "</p>";
    }

}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boek Toevoegen</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="nav-links">
    <a href="boeken.php" >Overzicht</a>
    <a href="boekentoe.php" >Boeken toevoegen</a>
</div>

<div class="add-book">
    <h2>Boek Toevoegen</h2>

    <form method="POST" id="boekForm">

        <label for="title">Title:</label><br>
        <input type="text"  name="title" required>
        <br><br>

        <label for="author">Author:</label><br>
        <input type="text"  name="author" required>
        <br><br>

        <label>Published Year:</label><br>
        <input type="number"  name="published_year" required min="0" max="9999">
        <br><br>

        <label>rating:</label><br>
        <input type="radio" name="rating" value="Bad" required> Bad<br>
        <input type="radio" name="rating" value="Mid"> Mid<br>
        <input type="radio" name="rating" value="Good"> Good<br>
        <input type="radio" name="rating" value="excellence"> Excellence<br><br>

        <label>Genre:</label><br>
        <input type="radio" name="genre" value="Fantasy" required> Fantasy<br>
        <input type="radio" name="genre" value="Thriller"> Thriller<br>
        <input type="radio" name="genre" value="Classic"> Classic<br>
        <input type="radio" name="genre" value="Programming"> Programming<br><br>

        <label>availability:</label><br>
        <input type="number"  name="availability" min="0" max="99" >
        <br><br>

        <input type="submit" value="Opslaan" id="submit-btn">

    </form>
</div>

</body>
</html>