<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Decorator/UserComponent.php';

class User implements UserComponent {

    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($username, $dob, $email, $password, $confirmpassword) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Generate a random 4-digit user ID
        $userID = rand(1000, 9999);
        
        $status = 1;

        // Prepare SQL query to insert user data including userID
        $sql = "INSERT INTO registeredUsers (userID, username, dob, email, password) 
                VALUES (:userID, :username, :dob, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        $sql2 = "INSERT INTO login (email, password, status) 
                 VALUES (:email, :password, :status)";
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt2->bindParam(':email', $email);
        $stmt2->bindParam(':password', $hashedPassword);
        $stmt2->bindParam(':status', $status, PDO::PARAM_INT); // Bind status as an integer
        $stmt2->execute();
    }

    public function readUser($email) {
        $sql = "SELECT * FROM registeredUsers WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($email, $data) {
        $sqlRegisteredUsers = "UPDATE registeredUsers 
                               SET username = :username, dob = :dob, password = :password 
                               WHERE email = :email";
        $stmt = $this->pdo->prepare($sqlRegisteredUsers);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':dob', $data['dob']);

        // Hash the password before updating
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Update the user's information in the login table
        $sqlLogin = "UPDATE login 
                     SET password = :password 
                     WHERE email = :email";
        $stmt = $this->pdo->prepare($sqlLogin);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    public function deleteUser($email) {
        $sql = "DELETE FROM registeredUsers WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $sqlLogin = "DELETE FROM login WHERE email = :email";
        $stmt = $this->pdo->prepare($sqlLogin);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    public function login($email, $password) {
        session_start(); // Start the session to manage user login state
        // Prepare SQL query to find user by email
        $sql = "SELECT userID, password, isAdmin FROM registeredUsers WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch the user's userID, hashed password, and isAdmin status from the database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['loggedin'] = true; // Set session variable to indicate logged-in state
            $_SESSION['email'] = $email; // Store the user's email in the session
            $_SESSION['customerID'] = $user['userID']; // Store the userID as customerID in the session
            $_SESSION['isAdmin'] = $user['isAdmin']; // Store isAdmin status in the session

            // Redirect based on isAdmin status
            if ($user['isAdmin']) {
                header("Location: ../Public/productAdmin.php"); // Redirect to admin page
            } else {
                header("Location: ../Views/homePage.php"); // Redirect to regular home page
            }
            exit();
        } else {
            // Login failed
            header("Location: ../Views/failedLogIn.php"); // Redirect to login failure page
            exit();
        }
    }


    public function register($username, $dob, $email, $password, $confirmpassword) {
        // Simple password match check
        if ($password !== $confirmpassword) {
            header("Location: ../Views/passwordNotMatch.php");
            exit;
        }

        // Validate password complexity
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            header("Location: ../Views/passwordFailed.php");
            exit;
        }

        // Check if the email already exists in the database
        $emailCheckQuery = "SELECT COUNT(*) FROM registeredUsers WHERE email = :email";
        $stmt = $this->pdo->prepare($emailCheckQuery);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            header("Location: ../Views/failedRegister.php");
            exit;
        }

        // Create a new user
        $this->createUser($username, $dob, $email, $password, $confirmpassword);


        if (!$stmt->execute()) {
            echo "Error: Could not store user login data.";
            exit;
        }

        // Redirect to a success page after successful signup
        header("Location: ../Views/successSignUp.php");
        exit;
    }
}

?>