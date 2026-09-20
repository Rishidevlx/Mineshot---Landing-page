<?php
// admin/api.php
header('Content-Type: application/json');

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/cloudinary.php';

if (!isAdminLoggedIn()) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized access.']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$pdo = getDBConnection();

switch ($action) {
    case 'status':
        $dbConnected = ($pdo !== null);
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $cloudinaryConfigured = (!empty($cloudName) && !empty($apiKey));

        echo json_encode([
            'success' => true,
            'db_connected' => $dbConnected,
            'cloudinary_configured' => $cloudinaryConfigured,
            'db_name' => env('DB_NAME', 'mineshot'),
            'cloud_name' => $cloudName ?: 'Not configured'
        ]);
        break;

    case 'list':
        if (!$pdo) {
            echo json_encode([
                'success' => false,
                'error' => 'Database is not connected. Please configure your TiDB Cloud credentials in the .env file.',
                'items' => []
            ]);
            exit;
        }

        try {
            $stmt = $pdo->query("SELECT * FROM projects_gallery ORDER BY display_order ASC, created_at DESC");
            $items = $stmt->fetchAll();

            echo json_encode([
                'success' => true,
                'items' => $items
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage(), 'items' => []]);
        }
        break;

    case 'upload':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
            exit;
        }

        if (!$pdo) {
            echo json_encode(['success' => false, 'error' => 'Database is not connected. Please fill DB credentials in .env first.']);
            exit;
        }

        // Collect uploaded files (support multiple 'images[]' or single 'image')
        $filesToProcess = [];
        if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
            $totalCount = count($_FILES['images']['name']);
            if ($totalCount > 10) {
                echo json_encode(['success' => false, 'error' => 'Maximum 10 images can be uploaded at a time. You selected ' . $totalCount . ' images.']);
                exit;
            }
            for ($i = 0; $i < $totalCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK && !empty($_FILES['images']['name'][$i])) {
                    $filesToProcess[] = [
                        'tmp_name' => $_FILES['images']['tmp_name'][$i],
                        'name' => $_FILES['images']['name'][$i]
                    ];
                }
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $filesToProcess[] = [
                'tmp_name' => $_FILES['image']['tmp_name'],
                'name' => $_FILES['image']['name']
            ];
        }

        if (empty($filesToProcess)) {
            echo json_encode(['success' => false, 'error' => 'Please select at least one valid image file to upload.']);
            exit;
        }

        if (count($filesToProcess) > 10) {
            echo json_encode(['success' => false, 'error' => 'Maximum 10 images can be uploaded at a time.']);
            exit;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $uploadedItems = [];
        $errors = [];

        $maxOrderStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) FROM projects_gallery");
        $nextOrder = intval($maxOrderStmt->fetchColumn());

        $insertStmt = $pdo->prepare("INSERT INTO projects_gallery (title, category, image_url, public_id, display_order) VALUES (?, 'project', ?, ?, ?)");
        $baseTitle = trim($_POST['title'] ?? '');
        $fileCount = count($filesToProcess);

        foreach ($filesToProcess as $idx => $f) {
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExtensions)) {
                $errors[] = "File '{$f['name']}' has unsupported type. Allowed: JPG, PNG, WEBP, GIF.";
                continue;
            }

            // Upload to Cloudinary
            $uploadResult = uploadToCloudinary($f['tmp_name'], 'mineshot/projects');
            if (!$uploadResult['success']) {
                $errors[] = "Failed to upload '{$f['name']}': " . $uploadResult['error'];
                continue;
            }

            $nextOrder++;
            $itemTitle = !empty($baseTitle) ? ($fileCount > 1 ? "{$baseTitle} #" . ($idx + 1) : $baseTitle) : pathinfo($f['name'], PATHINFO_FILENAME);

            try {
                $insertStmt->execute([$itemTitle, $uploadResult['url'], $uploadResult['public_id'], $nextOrder]);
                $uploadedItems[] = [
                    'id' => $pdo->lastInsertId(),
                    'title' => $itemTitle,
                    'category' => 'project',
                    'image_url' => $uploadResult['url'],
                    'public_id' => $uploadResult['public_id'],
                    'display_order' => $nextOrder
                ];
            } catch (Exception $e) {
                $errors[] = "Database insertion failed for '{$f['name']}': " . $e->getMessage();
            }
        }

        if (empty($uploadedItems)) {
            echo json_encode([
                'success' => false,
                'error' => !empty($errors) ? implode('; ', $errors) : 'No images were uploaded.'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => count($uploadedItems) . ' image(s) successfully uploaded to Projects Gallery!',
            'count' => count($uploadedItems),
            'items' => $uploadedItems,
            'errors' => $errors
        ]);
        break;

    case 'reorder':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
            exit;
        }

        if (!$pdo) {
            echo json_encode(['success' => false, 'error' => 'Database is not connected.']);
            exit;
        }

        $order = $_POST['order'] ?? [];
        if (!is_array($order)) {
            $order = json_decode($_POST['order'] ?? '[]', true);
        }

        if (!empty($order) && is_array($order)) {
            try {
                $stmt = $pdo->prepare("UPDATE projects_gallery SET display_order = ? WHERE id = ?");
                foreach ($order as $index => $id) {
                    $stmt->execute([$index, intval($id)]);
                }
                echo json_encode(['success' => true, 'message' => 'Image order updated successfully!']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => 'Reorder failed: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No order array provided.']);
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
            exit;
        }

        if (!$pdo) {
            echo json_encode(['success' => false, 'error' => 'Database is not connected.']);
            exit;
        }

        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'error' => 'Invalid image ID.']);
            exit;
        }

        try {
            // Find image record
            $stmt = $pdo->prepare("SELECT * FROM projects_gallery WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $item = $stmt->fetch();

            if (!$item) {
                echo json_encode(['success' => false, 'error' => 'Image not found in database.']);
                exit;
            }

            // Delete from Cloudinary if public_id exists
            if (!empty($item['public_id'])) {
                deleteFromCloudinary($item['public_id']);
            }

            // Delete from Database
            $deleteStmt = $pdo->prepare("DELETE FROM projects_gallery WHERE id = ?");
            $deleteStmt->execute([$id]);

            echo json_encode([
                'success' => true,
                'message' => 'Image successfully deleted from Cloudinary and Database.'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Delete failed: ' . $e->getMessage()]);
        }
        break;

    case 'update_settings':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
            exit;
        }

        $newEmail = trim($_POST['email'] ?? '');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($newEmail)) {
            echo json_encode(['success' => false, 'error' => 'Email address cannot be empty.']);
            exit;
        }

        if (!$pdo) {
            echo json_encode(['success' => false, 'error' => 'TiDB database is not connected. Please fill .env credentials first.']);
            exit;
        }

        try {
            $adminEmail = getLoggedInAdminEmail();
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? LIMIT 1");
            $stmt->execute([$adminEmail]);
            $adminUser = $stmt->fetch();

            if (!$adminUser) {
                $stmt = $pdo->query("SELECT * FROM admin_users LIMIT 1");
                $adminUser = $stmt->fetch();
            }

            if ($adminUser && !empty($currentPassword)) {
                if (!password_verify($currentPassword, $adminUser['password_hash'])) {
                    echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
                    exit;
                }
            }

            if (!empty($newPassword)) {
                if (strlen($newPassword) < 6) {
                    echo json_encode(['success' => false, 'error' => 'New password must be at least 6 characters.']);
                    exit;
                }
                if ($newPassword !== $confirmPassword) {
                    echo json_encode(['success' => false, 'error' => 'New password and confirm password do not match.']);
                    exit;
                }
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);

                if ($adminUser) {
                    $updateStmt = $pdo->prepare("UPDATE admin_users SET email = ?, password_hash = ? WHERE id = ?");
                    $updateStmt->execute([$newEmail, $newHash, $adminUser['id']]);
                } else {
                    $insertStmt = $pdo->prepare("INSERT INTO admin_users (email, password_hash) VALUES (?, ?)");
                    $insertStmt->execute([$newEmail, $newHash]);
                }
            } else {
                if ($adminUser) {
                    $updateStmt = $pdo->prepare("UPDATE admin_users SET email = ? WHERE id = ?");
                    $updateStmt->execute([$newEmail, $adminUser['id']]);
                }
            }

            $_SESSION['admin_email'] = $newEmail;

            echo json_encode([
                'success' => true,
                'message' => 'Admin settings successfully updated!',
                'new_email' => $newEmail
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Update failed: ' . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Unknown action.']);
        break;
}
