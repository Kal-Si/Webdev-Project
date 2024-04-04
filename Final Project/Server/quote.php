
<?php

require('connect.php');

$Title = "";
$Quotes = "";

if ($_POST && !empty($_POST['Title']) && !empty($_POST['Quotes'])) 
{
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $Title = filter_input(INPUT_POST, 'Title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Quotes = filter_input(INPUT_POST, 'Quotes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $query = "INSERT INTO quote (Title, Quotes) VALUES (:Title, :Quotes)";
    $statement = $db->prepare($query);
    
    //  Bind values to the parameters
    $statement->bindValue(':Title', $Title);
    $statement->bindValue(':Quotes', $Quotes);
    
    //  Execute the INSERT.
    //  execute() will check for possible SQL injection and remove if necessary
    $statement->execute();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kruse Autobody - Get a Quote</title>
    <link rel="stylesheet" href="quoteStyles.css?v=<?php echo time(); ?>">
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
        <h2>Get a Quote</h2>

        <?php if(!isset($_POST['Title']) && !isset($_POST['Quotes'])): ?>
                <form action="quote.php" method="post">
                    <p>
                    <label for="Title">Title</label>
                    <input name="Title" id="Title">
                    </p>
                    <p>
                    <label for="Quotes">Quote</label>
                    <textarea name="Quotes" id="Quotes" rows="5" cols="50" maxlength="1000"></textarea>
                    </p>
                    <p>
                    <input type="submit" value="submit">
                    </p>
                </form>
            <?php elseif(empty($Title) || empty($Quotes)): ?>
                <h3>Both the title and content must be filled.</h3>
            <?php else: ?>
                <h3>Quote has been sent!</h3>
            <?php endif ?>
    </section>

    <footer>
        <p>&copy; 2024 Kruse Autobody</p>
    </footer>

</body>
</html>
