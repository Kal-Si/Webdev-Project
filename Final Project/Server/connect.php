<?php
 define('DB_DSN','mysql:host=localhost;dbname=serverside;charset=utf8');
 define('DB_USER','serveruser');
 define('DB_PASS','gorgonzola7!');  

try {
    // Try creating new PDO connection to MySQL.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS);

    // Set PDO to throw exceptions on errors.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user has the necessary permissions.
    $stmt = $db->prepare("SHOW GRANTS FOR :user@'localhost'");
    $stmt->bindValue(':user', DB_USER);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        die("Error: The user '{$DB_USER}' does not have permission to access the 'project' database.");
    }

} catch (PDOException $e) {
    // Print detailed error message.
    die("Error: " . $e->getMessage());
}
?>
