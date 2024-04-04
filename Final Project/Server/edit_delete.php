
<?php

require('connect.php');
require('authenticate.php');

// Check if the form is submitted and the review ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) 
{
    // Sanitize the input ID
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    // Check if the ID is valid
    if ($id !== false) 
    {
        // Check if the update button is clicked
        if (isset($_POST['updateButton'])) 
        {
            // Sanitize and validate the input title and content
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

            // Prepare and execute the SQL query to update the review in the database
            $query = "UPDATE comment SET title = :title, content = :content WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->bindParam(':content', $content, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $success = $statement->execute();

            if ($success) 
            {
                // Redirect to index.php after successful update
                header("Location: ../index.php");
                exit;
            } else 
            {
                echo "Failed to update the review.";
            }
        } 

        elseif (isset($_POST['deleteButton'])) 
        {
            // Prepare and execute the SQL query to delete the review from the database
            $query = "DELETE FROM comment WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $success = $statement->execute();

            if ($success) 
            {
                // Redirect to index.php after successful deletion
                header("Location: ../index.php");
                exit;
            } 

            else 
            {
                echo "Failed to delete the review.";
            }
        }

         else 
        {
            // Fetch the review data from the database
            $query = "SELECT * FROM comment WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Check if the review data is fetched successfully
            if ($row !== false) 
            {
                // Display the form with the fetched review data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css?v=<?php echo time(); ?>">
    <title>Edit this Review!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="edit_delete_body">

        <div id="header">
            <h1>Kruse AutoBody - Edit Review</h1>
        </div> 

        <ul id="menu">
            <li><a href="../index.php">Home</a></li>
            <li><a href="review.php">New Post</a></li>
        </ul> 

        <div id="body">

            <form class="edit" action="edit_delete.php" method="post">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <p>
                    <label for="title">Title</label>
                    <input name="title" id="title" value="<?= htmlspecialchars($row['title']) ?>">
                </p>
                <p>
                    <label for="content">Content</label>
                    <textarea name="content" id="content"><?= htmlspecialchars($row['content']) ?></textarea>
                </p>
                <div id="edit_buttons">
                    <p>
                        <input type="submit" name="updateButton" value="Update">
                        <input class="delete_button" type="submit" name="deleteButton" value="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
                    </p>
                </div>
            </form>

        </div>

        <div id="footer">
            &copy; 2023 - Some Rights Reserved
        </div> 

    </div>   
</body>
</html>
<?php
                exit; // Exit to prevent further execution of the script
            }

            else 
            {
                // Handle the case when review data is not found
                echo "Review data not found.";
            }
        }
    } 

    else 
    {
        // Handle the case when the provided ID is invalid
        echo "Invalid review ID.";
    }
}

else 
{
    // Handle the case when the form is not submitted or the ID is not provided
    echo "Form not submitted or ID not provided.";
}

?>
