<?php
// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
require_once 'config.php';

// REDIRECT IF ALREADY LOGGED IN
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                header('Location: home.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
        $stmt->close();
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fce4ec;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-pink {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(233, 30, 99, 0.15);
            width: 100%;
            max-width: 400px;
        }
        .btn-pink {
            background-color: #f06292;
            border-color: #f06292;
            color: #ffffff;
            font-weight: 600;
        }
        .btn-pink:hover {
            background-color: #ec407a;
            border-color: #ec407a;
            color: #ffffff;
        }
        .pink-text {
            color: #d81b60;
        }
        .form-control:focus {
            border-color: #f06292;
            box-shadow: 0 0 0 0.25rem rgba(240, 98, 146, 0.25);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center p-3">
    <div class="card card-pink p-4">
        <div class="text-center mb-4">
            <h3 class="pink-text fw-bold">Sign In</h3>
            <p class="text-muted small">Enter your account credentials to continue</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 text-center" role="alert" style="font-size: 0.875rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="username" class="form-label text-secondary small fw-bold">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label text-secondary small fw-bold">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-pink w-100 py-2">Login</button>
        </form>
    </div>
</div>

<script>
    window.addEventListener('pageshow', function (event) {
        if (event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>

</body>
</html>