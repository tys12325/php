<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

session_start();
include('../Models/connection.php');

class resetPasswordController {
    private $connect;

    // Constructor to initialize the database connection
    public function __construct($connect) {
        $this->connect = $connect;
    }

    // Public function to handle password reset
    public function resetPassword() {
        // Check if the form is submitted
        if (isset($_POST["reset"])) {
            // Check if session variables are set
            if (isset($_SESSION['token']) && isset($_SESSION['email'])) {
                $psw = $_POST["password"];
                $token = $_SESSION['token'];
                $Email = $_SESSION['email'];

                // Hash the new password
                $hash = password_hash($psw, PASSWORD_DEFAULT);

                // Validate if email exists in 'login' table using prepared statements
                $stmt = $this->connect->prepare("SELECT * FROM login WHERE email=?");
                $stmt->bind_param("s", $Email);
                $stmt->execute();
                $result = $stmt->get_result();
                $fetch = $result->fetch_assoc();

                if ($fetch) {
                    // Update password in 'login' table
                    $stmt = $this->connect->prepare("UPDATE login SET password=? WHERE email=?");
                    $stmt->bind_param("ss", $hash, $Email);
                    $stmt->execute();

                    // Update password in 'registeredUsers' table
                    $stmt = $this->connect->prepare("UPDATE registeredUsers SET password=? WHERE email=?");
                    $stmt->bind_param("ss", $hash, $Email);
                    $stmt->execute();

                    // Success message and redirection
                    echo '<script>
                            window.location.replace("../Views/userLogin.php");
                            alert("Your password has been successfully reset");
                          </script>';
                } else {
                    // If email is not found in the database
                    echo '<script>
                            alert("Please try again");
                          </script>';
                }
            } else {
                // If session variables are not set
                echo '<script>
                        alert("Invalid session. Please try again.");
                      </script>';
            }
        }
    }
}

// Usage example
$passwordResetManager = new resetPasswordController($connect);
$passwordResetManager->resetPassword();
?>

<!-- Include the necessary external files for Bootstrap and jQuery -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    // Password visibility toggle script
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function() {
        // Toggle between showing and hiding the password
        password.type = password.type === "password" ? 'text' : 'password';
        this.classList.toggle('bi-eye');
    });
</script>
