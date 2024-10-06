<?php
// Get the input values from POST
$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];

include '../server/conn.php'; // Include the database connection

// Use prepared statements to avoid SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;

if($count == 0){
    // Use password_hash() for password hashing
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
    
    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO users (name, email, pass) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_pass);
    
    if($stmt->execute()){ // Execute the query and check if successful
        // Get the last inserted ID
        $newUserId = mysqli_insert_id($conn);
        
        // Set cookies for email, name, and the newly added user ID
        setcookie('usere', $email, time() + (86400 * 30), "/");
        setcookie('namee', $name, time() + (86400 * 30), "/");
        setcookie('useride', $newUserId, time() + (86400 * 30), "/");
        
        echo '<script>
                window.location.href = "../";
              </script>';
    } else {
        echo "Error: " . $stmt->error."will be again try again 4 sec". // Output any errors
        '<script>
        setTimeout(function(){
            window.location.href = "./signup.php";
        }, 4000); // Redirect to signup page after 4 seconds
                
              </script>';
    }
} else {
    echo '<script>
            alert("Email already registered");
            window.location.href = "../auth/login.php";
          </script>';
}

// Close the prepared statement and connection
$stmt->close();
$conn->close();
?>
