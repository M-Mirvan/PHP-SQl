<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=bibliotheek rotterdam;charset=utf8';
$username = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Collect filters from GET
$title = isset($_GET['title']) ? trim($_GET['title']) : '';
$author = isset($_GET['author']) ? trim($_GET['author']) : '';
$genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';
$published_year = isset($_GET['published_year']) ? trim($_GET['published_year']) : '';

// Build query dynamically
$sql = "SELECT * FROM books WHERE 1=1";
$params = [];

if ($title !== '') {
    $sql .= " AND title LIKE :title";
    $params[':title'] = "%$title%";
}
if ($author !== '') {
    $sql .= " AND author LIKE :author";
    $params[':author'] = "%$author%";
}
if ($genre !== '') {
    $sql .= " AND genre = :genre";
    $params[':genre'] = $genre;
}
if ($published_year !== '') {
    $sql .= " AND published_year = :published_year";
    $params[':published_year'] = $published_year;
}

// Prepare and execute
$stmt = $dbh->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch distinct genres and years for dropdowns
$genres = $dbh->query("SELECT DISTINCT genre FROM books ORDER BY genre")->fetchAll(PDO::FETCH_COLUMN);
$years = $dbh->query("SELECT DISTINCT published_year FROM books ORDER BY published_year DESC")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Filter</title>
</head>
<body>
<h2>Filter Books</h2>
<form method="GET">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($title) ?>"><br><br>
    Author: <input type="text" name="author" value="<?= htmlspecialchars($author) ?>"><br><br>
    
    Genre:
    <select name="genre">
        <option value="">-- All Genres --</option>
        <?php foreach ($genres as $g): ?>
            <option value="<?= htmlspecialchars($g) ?>" <?= $g == $genre ? 'selected' : '' ?>><?= htmlspecialchars($g) ?></option>
        <?php endforeach; ?>
    </select><br><br>
    
    Published Year:
    <select name="published_year">
        <option value="">-- All Years --</option>
        <?php foreach ($years as $y): ?>
            <option value="<?= htmlspecialchars($y) ?>" <?= $y == $published_year ? 'selected' : '' ?>><?= htmlspecialchars($y) ?></option>
        <?php endforeach; ?>
    </select><br><br>
    
    <button type="submit">Filter</button>
</form>

<h3>Results:</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>title</th>
        <th>author</th>
        <th>genre</th>
        <th>Published Year</th>
    </tr>
    <?php if (!empty($results)): ?>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= htmlspecialchars($row['genre']) ?></td>
            <td><?= htmlspecialchars($row['published_year']) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="4">No results found.</td></tr>
    <?php endif; ?>
</table>
</body>
</html>