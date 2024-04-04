<?php

require('connect.php');

$title = "";
$content = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if form fields are not empty
    if (!empty($_POST['title']) && !empty($_POST['content'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Prepare and execute the SQL query to insert the comment into the database
        $query = "INSERT INTO comment (title, content) VALUES (:title, :content)";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        
        // Check if the execution was successful
        if ($statement->execute()) {
            // Set success message if comment was posted successfully
            $success_message = "Comment has been successfully Posted!";
        } else {
            // If execution fails, display an error message
            $error_message = "Failed to post the comment.";
        }
    } else {
        // If form fields are empty, display an error message
        $error_message = "Both the title and comment must be filled.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kruse Autobody - Review</title>
    <link rel="stylesheet" href="CommentsStyles.css?v=<?php echo time(); ?>">
</head>
<body>

    <header>
        <h1>Kruse Autobody</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../Server/quote.php">Get a Quote</a></li>
                <li><a href="../Text/services.php">Services</a></li>
                <li><a href="../gallery.php">Gallery</a></li>
                <li><a href="../Text/about.php">About Us</a></li>
                <li><a href="../Text/contact.php">Contact Us</a></li>
                <li><a href="review.php">Review</a></li>
                <li><a href="../Text/MPI Info.php">MPI Info</a></li>
                <li><a href="../Text/MPI Info.php">MPI Map</a></li>
                <li><a href="../Server/login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <section id="main-content">
        <h2>Leave a Review</h2>

        <?php if(isset($error_message)): ?>
            <h3><?php echo $error_message; ?></h3>
        <?php elseif (!empty($success_message)): ?>
            <h3><?php echo $success_message; ?></h3>
        <?php endif; ?>

        <form action="review.php" method="post">
            <p>
                <label for="title">Service Used</label>
                <input name="title" id="title" size="50">
            </p>
            <p>
                <label for="content">Review</label>
                <textarea name="content" id="content" rows="5" cols="50" maxlength="1000"></textarea>
            </p>
            <p>
                <input type="submit" value="submit">
            </p>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Kruse Autobody</p>
    </footer>

</body>
</html>
