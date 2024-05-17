<?php
    include 'config1.php';
    
    if(isset($_POST['login-submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $select = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $select);

        if($result && mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result); // Fetch the user information
            session_start();
            $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the user ID column
            $_SESSION['username'] = $row['username'];
            $_SESSION['usertype'] = $row['usertype']; // Add this line
            
            if ($_SESSION['usertype'] === 'Admin') {
                header('Location: admin.php'); // Redirect to admin page
                exit();
            } else {
                header('Location: user.html'); // Redirect to user page
                exit();
            }
        } else {
            $error = 'Incorrect email or password';
        }
    }

    if(isset($_POST['register-submit'])){
        $name = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $select = "SELECT * FROM login WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if($result && mysqli_num_rows($result) > 0){
            $error = 'User already exists!';
        } else {
            $insert = "INSERT INTO login(username, email, password, usertype) VALUES('$name','$email','$password', 'user')";
            mysqli_query($conn, $insert);
            header('Location: index1.php');
            exit();
        }
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="s.css">
</head>
<body>
    <header>
        <h2 class="Logo">Counseling</h2>
        <nav class="navigation">
            <a href="index.php">Home</a>
            <a href="courses.html">Courses</a>
            <a href="College.html">College</a>
            <a href="Jobs.html">Jobs</a>
            <a href="contact.html">Contact</a>
            <button class="btnLogin-popup">Login</button>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>

        <div class="form-box login">
            <h2>Login</h2>
            <?php if(isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="text" required name="email">
                    <label>Email</label>
                </div>
    
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" required name="password">
                    <label>Password</label>
                </div>
    
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>
    
                <button type="submit" name="login-submit" class="btn">Login</button>
    
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>
    
        <div class="form-box register">
            <h2>Registration</h2>
            <form action="" method="post">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" required name="username">
                    <label>Username</label>
                </div>
    
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" required name="email">
                    <label>Email</label>
                </div>
    
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" required name="password">
                    <label>Password</label>
                </div>
    
                <div class="remember-forgot">
                    <label><input type="checkbox">I agree to the terms and conditions</label>
                </div>
    
                <button type="submit" name="register-submit" class="btn">Register</button>
    
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
