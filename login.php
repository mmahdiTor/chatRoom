<?php
include 'db.php';

$users = [
    "Amir" => "1234",
    "Kamran" => "5678"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';

    if (isset($users[$u]) && $users[$u] === $p) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $u;
        header("Location: index.php");
        exit;
    } else {
        $error = "نام کاربری یا رمز اشتباه است";
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ورود به چت</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
* {
    box-sizing: border-box; /* مهم برای padding و width */
    margin:0;
    padding:0;
}

body {
    font-family:'Inter', Tahoma, sans-serif;
    background: #0f2027;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* کارت مرکز شده */
.login-box {
    width: 100%;
    max-width: 350px;
    min-width: 280px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    color: #fff;
    display:flex;
    flex-direction: column;
    gap:10px;
}

/* عنوان */
.login-box h3 {
    font-weight: 600;
    font-size: 20px;
    margin-bottom: 20px;
}

/* input ها */
.login-box input {
    width: 100%;
    padding: 12px 12px; 
    margin: 8px 0;
    border-radius: 30px;
    border: none;
    outline: none;
    background: rgba(255,255,255,0.1);
    color: #fff;
    font-size: 14px;
    transition: 0.3s;
}

/* placeholder */
.login-box input::placeholder {
    color: rgba(255,255,255,0.6);
}

.login-box button {
    width: 100%;
    padding: 12px 15px; 
    border-radius: 30px;
    border: none;
    outline: none;
    background: linear-gradient(135deg,#00c6ff,#0072ff);
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}

.login-box button:hover {
    opacity: 0.9;
}

.login-box p.error {
    color: #ff6b6b;
    font-size: 13px;
    margin-bottom: 5px;
}

/* Responsive */
@media (max-width:480px){
    .login-box { width: 90%; padding: 25px 20px; }
    .login-box h3 { font-size: 18px; }
    .login-box input { font-size: 14px; padding:10px 12px; }
    .login-box button { font-size: 14px; padding:10px 12px; }
}
</style>
</head>
<body>

<div class="login-box">
    <h3>ورود به چت‌روم</h3>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input name="username" placeholder="نام کاربری" required>
        <input type="password" name="password" placeholder="رمز عبور" required>
        <button>ورود</button>
    </form>
</div>

</body>
</html>
