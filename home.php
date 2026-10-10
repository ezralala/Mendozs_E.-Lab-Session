<?php
// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fce4ec;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-pink {
            background-color: #ffffff;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.08);
        }
        .card-pink {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(233, 30, 99, 0.12);
        }
        .btn-pink-outline {
            border: 2px solid #f06292;
            color: #d81b60;
            font-weight: 600;
        }
        .btn-pink-outline:hover {
            background-color: #f06292;
            color: #ffffff;
        }
        .pink-text {
            color: #d81b60;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-pink py-3">
    <div class="container">
        <a class="navbar-brand pink-text fw-bold" href="home.php">My Application</a>
        <div class="d-flex align-items-center gap-3">
            <span class="text-secondary small d-none d-sm-inline">
                Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
            </span>
            <a href="logout.php" class="btn btn-pink-outline btn-sm px-3">Logout</a>
        </div>
    </div>
</nav>


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-pink p-4 p-md-5 text-center">
                <h2 class="pink-text fw-bold mb-3">Welcome to Your Home Page!</h2>
                <p class="text-muted">You are successfully logged in.</p>
                
                <div class="alert bg-light border-0 py-3 my-4" style="color: #c2185b;">
                Welcome <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> !
                </div>
            </div>
        </div>
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