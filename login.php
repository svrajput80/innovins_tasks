<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .container h2 {
            margin: 0 0 20px;
        }
        .container input[type="email"],
        .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #218838;
        }
        .container .register-link {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
        .container .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .container .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
   
    <div class="container">
        <h2>Login</h2>
        <?php  session_start(); if(!empty($_SESSION["error"])){echo "<div style='color: red;'>". $_SESSION["error"] . "</div>";  } session_destroy(); ?>
        <form action="authUser.php" method="post">
            <input type="text" name="login" value="authuser" placeholder="Username" style="display: none;">
            <input type="email" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
        <div class="register-link">
            <p>If you forget your account Password <a href="forgetPassword.php">Forget Password</a></p>
        </div>
    </div>
</body>
</html>
