<?php
$baseURL = "http://localhost/perpustakaan";
require __DIR__ . "/../config.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check user & password
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_data'] = [
                'id_user' => $user['id_user'],
                'username' => $user['username'],
                'role' => $user['role'],
                'is_logged_in' => true
            ];

            header("Location: $baseURL/dashboard.php");
            exit;
        }

        // Login failed
        header("Location: $baseURL/auth/login.php?error=1");
        exit;
    } catch (Exception $e) {
        echo "Gagal Login: " . $e->getMessage();
        exit;
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <title>Login | Perpustakaan</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <style>
        body {
            background-color: #f4f6f9;
        }
        .login-card {
            max-width: 400px;
            margin: auto;
            margin-top: 15vh;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card login-card shadow">
        <div class="card-body">
            <h3 class="text-center mb-4">Login</h3>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    Username atau password salah
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>