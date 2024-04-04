<?php
require('Server/connect.php');

// Retrieve all comments from the database
$query = "SELECT * FROM comment";
$statement = $db->query($query);
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kruse Autobody</title>
    <link rel="stylesheet" href="IndexStyles.css?v=<?php echo time(); ?>">
</head>
<body>

    <header>
        <h1>Kruse Autobody</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="Server/quote.php">Get a Quote</a></li>
                <li><a href="Text/services.php">Services</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="Text/about.php">About Us</a></li>
                <li><a href="Text/contact.php">Contact Us</a></li>
                <li><a href="Server/review.php">Review</a></li>
                <li><a href="Text/MPI Info.php">MPI Info</a></li>
                <li><a href="Text/MPI Map.php">MPI Map</a></li>
                <li><a href="Server/login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <section id="main-content">
        
        <h2>Welcome to Kruse Autobody</h2>

        <div id = "Kruse-Map">

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2569.8000146446!2d-97.1518386235962!3d49.90255777149271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52ea716040edcd69%3A0xf766936769041403!2sKruse%20Auto%20Body%20Ltd!5e0!3m2!1sen!2sca!4v1710373048563!5m2!1sen!2sca" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>

    </section>

    <div id="reviews">

        <h2>Customer Reviews:</h2>
        <?php if (count($comments) > 0): ?>
            <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <h3><?php echo $comment['title']; ?></h3>
                    <p><?php echo $comment['content']; ?></p>

                    <!-- Edit and delete buttons -->
                    <form action="Server/edit_delete.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                        <input type="submit" name="editButton" value="Edit">
                    </form>

                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>

        <footer>
            <p>&copy; 2024 Kruse Autobody</p>
        </footer>

        <div>
            <br></br>
            <br></br>
        </div>

</body>
</html>
