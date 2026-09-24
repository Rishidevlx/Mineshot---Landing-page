<?php
// admin/login.php
require_once __DIR__ . '/auth.php';

if (isAdminLoggedIn()) {
    header('Location: /admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $pdo = getDBConnection();
        $authenticated = false;

        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $authenticated = true;
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_email'] = $user['email'];
            }
        }

        // Fallback for initial local setup before DB is filled in .env
        if (!$authenticated) {
            $defaultEmail = env('DEFAULT_ADMIN_EMAIL', 'admin@mineshot.in');
            $defaultPass = env('DEFAULT_ADMIN_PASSWORD', 'admin123');
            if ($email === $defaultEmail && $password === $defaultPass) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = 1;
                $_SESSION['admin_email'] = $defaultEmail;
                $authenticated = true;
            }
        }

        if ($authenticated) {
            header('Location: /admin/index.php');
            exit;
        } else {
            $error = 'Invalid email address or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mineshot - Admin Login</title>
    <link rel="shortcut icon" href="../assets/img/mineshot/mineshot-icon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fonts/bootstrap-icons-1.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        :root {
            --bg-dark: #0f1012;
            --bg-card: #18191d;
            --border-color: #272930;
            --gold-primary: #d3bc7e;
            --gold-hover: #e5d19b;
            --text-primary: #ffffff;
            --text-secondary: #9aa0a6;
        }

        body {
            background-color: var(--bg-dark);
            font-family: 'DM Sans', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: radial-gradient(circle at 50% 0%, rgba(211, 188, 126, 0.08) 0%, transparent 70%);
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold-primary), transparent);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            max-height: 55px;
            margin-bottom: 15px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-label {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: #121316;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #15171b;
            border-color: var(--gold-primary);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(211, 188, 126, 0.15);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold-primary), #b39b59);
            color: #000;
            font-weight: 600;
            font-size: 15px;
            padding: 13px 20px;
            border-radius: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, var(--gold-hover), var(--gold-primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(211, 188, 126, 0.25);
            color: #000;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 10px;
            font-size: 14px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
        }

        .back-link a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: var(--gold-primary);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-logo">
            <img src="../assets/img/mineshot/mineshot-logo.png" alt="Mineshot Logo">
            <h2 class="login-title">Admin Portal</h2>
            <p class="login-subtitle">Sign in to manage images and projects</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?= htmlspecialchars($error) ?></div>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? 'admin@mineshot.in') ?>" placeholder="name@mineshot.in" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-gold">
                <i class="bi bi-box-arrow-in-right me-2"></i> Log In to Dashboard
            </button>
        </form>

        <div class="back-link">
            <a href="../index.php"><i class="bi bi-arrow-left me-1"></i> Back to Main Website</a>
        </div>
    </div>

</body>
</html>
