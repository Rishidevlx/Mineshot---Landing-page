<?php
// admin/index.php
require_once __DIR__ . '/auth.php';
requireAdminAuth();

$adminEmail = getLoggedInAdminEmail();
$pdo = getDBConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mineshot - Admin Dashboard</title>
    <link rel="shortcut icon" href="../assets/img/mineshot/mineshot-icon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fonts/bootstrap-icons-1.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- SortableJS for smooth drag and drop reordering -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <style>
        :root {
            --bg-dark: #0c0d0f;
            --bg-card: #141518;
            --bg-card-hover: #1a1c21;
            --border-color: #23252b;
            --gold-primary: #d3bc7e;
            --gold-hover: #e5d19b;
            --text-primary: #ffffff;
            --text-secondary: #9aa0a6;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --success: #10b981;
        }

        body {
            background-color: var(--bg-dark);
            font-family: 'DM Sans', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .admin-navbar {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .admin-brand img {
            max-height: 38px;
        }

        .admin-badge {
            background: rgba(211, 188, 126, 0.15);
            color: var(--gold-primary);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(211, 188, 126, 0.3);
        }

        /* Navigation Tabs */
        .admin-tabs {
            display: flex;
            gap: 8px;
            border-bottom: 1px solid var(--border-color);
            padding: 0 28px;
            background-color: #101114;
        }

        .admin-tab-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 600;
            padding: 16px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            transition: all 0.2s;
        }

        .admin-tab-btn:hover {
            color: var(--text-primary);
        }

        .admin-tab-btn.active {
            color: var(--gold-primary);
        }

        .admin-tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--gold-primary);
        }

        /* Container */
        .admin-content {
            padding: 30px 28px;
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* Cards */
        .admin-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Reorder instruction banner */
        .reorder-hint {
            background: rgba(211, 188, 126, 0.08);
            border: 1px dashed rgba(211, 188, 126, 0.35);
            border-radius: 10px;
            padding: 12px 18px;
            color: #d8c48e;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Image Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }

        .gallery-item-card {
            background-color: #17181d;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            display: flex;
            flex-direction: column;
            position: relative;
            cursor: grab;
            user-select: none;
        }

        .gallery-item-card:active {
            cursor: grabbing;
        }

        .gallery-item-card.sortable-ghost {
            opacity: 0.3;
            border: 2px dashed var(--gold-primary);
            background-color: #21232b;
        }

        .gallery-item-card.sortable-chosen {
            box-shadow: 0 14px 30px rgba(0,0,0,0.8);
            border-color: var(--gold-primary);
        }

        .gallery-item-card:hover {
            border-color: rgba(211, 188, 126, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .gallery-item-thumb {
            position: relative;
            padding-top: 68%;
            background-color: #0d0e11;
            overflow: hidden;
        }

        .gallery-item-thumb img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
        }

        .order-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            color: var(--gold-primary);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid rgba(211, 188, 126, 0.4);
            z-index: 2;
        }

        .drag-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            color: #ffffff;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 2;
            cursor: grab;
        }

        .gallery-item-body {
            padding: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .gallery-item-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .btn-delete {
            background-color: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }

        .btn-delete:hover {
            background-color: var(--danger);
            color: #fff;
            border-color: var(--danger);
        }

        /* Upload Area */
        .upload-dropzone {
            border: 2px dashed var(--border-color);
            background-color: #111215;
            border-radius: 14px;
            padding: 36px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .upload-dropzone:hover, .upload-dropzone.dragover {
            border-color: var(--gold-primary);
            background-color: rgba(211, 188, 126, 0.04);
        }

        .upload-icon {
            font-size: 44px;
            color: var(--gold-primary);
            margin-bottom: 12px;
        }

        .batch-limit-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(211, 188, 126, 0.15);
            border: 1px solid rgba(211, 188, 126, 0.3);
            color: var(--gold-primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
        }

        /* Multi-Image Preview Grid */
        .preview-wrapper {
            margin-top: 20px;
            display: none;
        }

        .preview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 12px;
            max-height: 380px;
            overflow-y: auto;
            padding: 6px;
        }

        .preview-card {
            position: relative;
            background-color: #1a1c22;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
        }

        .preview-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-card .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(239, 68, 68, 0.85);
            color: white;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            transition: transform 0.15s ease;
        }

        .preview-card .remove-btn:hover {
            transform: scale(1.15);
            background: var(--danger);
        }

        .preview-card .preview-card-index {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
        }

        /* Form Controls */
        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .form-control {
            background-color: #111215;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
        }

        .form-control:focus {
            background-color: #14161a;
            border-color: var(--gold-primary);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(211, 188, 126, 0.15);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold-primary), #b39b59);
            color: #000;
            font-weight: 600;
            font-size: 14px;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, var(--gold-hover), var(--gold-primary));
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(211, 188, 126, 0.25);
            color: #000;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 13px;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            border-color: var(--text-primary);
            color: var(--text-primary);
        }

        /* Custom Delete Confirmation Modal */
        .custom-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .custom-modal-backdrop.show {
            display: flex;
            opacity: 1;
        }

        .custom-modal-box {
            background: #15171c;
            border: 1px solid #2b2e38;
            border-radius: 16px;
            width: 90%;
            max-width: 440px;
            padding: 28px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.85);
            transform: scale(0.92);
            transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .custom-modal-backdrop.show .custom-modal-box {
            transform: scale(1);
        }

        .modal-icon-circle {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--danger);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 18px;
        }

        .modal-preview-thumb {
            width: 100%;
            height: 140px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid var(--border-color);
            margin-bottom: 16px;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .modal-actions button {
            flex: 1;
            padding: 11px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-modal-cancel {
            background: #23252e;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-modal-cancel:hover {
            background: #2d303b;
            color: #fff;
        }

        .btn-modal-delete {
            background: var(--danger);
            color: #fff;
        }

        .btn-modal-delete:hover {
            background: var(--danger-hover);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.35);
        }

        /* Toast Alert */
        #toastContainer {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99999;
        }

        .toast-msg {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: #fff;
            padding: 14px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 10px;
            animation: slideIn 0.3s ease forwards;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 50px;
            color: #33363f;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <header class="admin-navbar">
        <div class="d-flex align-items-center gap-3">
            <a href="index.php" class="admin-brand">
                <img src="../assets/img/mineshot/mineshot-logo.png" alt="Mineshot">
                <span class="admin-badge">Admin Panel</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="../index.php" target="_blank" class="btn-outline-custom">
                <i class="bi bi-box-arrow-up-right me-1"></i> Live Site
            </a>

            <a href="logout.php" class="btn-outline-custom text-danger border-danger-subtle">
                <i class="bi bi-power me-1"></i> Logout
            </a>
        </div>
    </header>

    <!-- Navigation Tabs -->
    <nav class="admin-tabs">
        <button class="admin-tab-btn active" onclick="switchTab('tab-gallery', this)">
            <i class="bi bi-images"></i> All Uploaded Images
        </button>
        <button class="admin-tab-btn" onclick="switchTab('tab-upload', this)">
            <i class="bi bi-cloud-arrow-up"></i> Upload Images (Max 10)
        </button>
        <button class="admin-tab-btn" onclick="switchTab('tab-settings', this)">
            <i class="bi bi-gear"></i> Settings
        </button>
    </nav>

    <!-- Main Content Area -->
    <main class="admin-content">

        <!-- TAB 1: ALL IMAGES (GALLERY & DRAG-AND-DROP REORDER) -->
        <section id="tab-gallery" class="tab-pane-content">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                <div>
                    <h3 class="fw-bold mb-1">Our Projects Gallery</h3>
                    <p class="text-secondary small mb-0">Drag and drop images to change their display order on the live website.</p>
                </div>
                <button class="btn-gold" onclick="switchTab('tab-upload', document.querySelectorAll('.admin-tab-btn')[1])">
                    <i class="bi bi-plus-lg"></i> Upload New Images
                </button>
            </div>

            <!-- Drag and Drop Hint Banner -->
            <div class="reorder-hint">
                <i class="bi bi-arrows-move fs-5"></i>
                <span><strong>Drag & Drop to Reorder:</strong> Grab any card to change its position. The order will instantly update on the Our Projects page and Home portfolio!</span>
            </div>

            <!-- Image Grid Container -->
            <div id="galleryContainer" class="gallery-grid">
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div class="spinner-border text-warning" role="status"></div>
                    <p class="mt-3">Loading images from database...</p>
                </div>
            </div>
        </section>

        <!-- TAB 2: UPLOAD UP TO 10 IMAGES -->
        <section id="tab-upload" class="tab-pane-content" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="admin-card">
                        <h4 class="card-header-title">
                            <i class="bi bi-cloud-arrow-up text-warning"></i> Upload Images to Projects Gallery
                        </h4>

                        <form id="uploadForm">
                            <div class="mb-4">
                                <label class="form-label">Select Images (Maximum 10 images)</label>
                                <div class="upload-dropzone" id="dropzone" onclick="document.getElementById('imageFileInput').click()">
                                    <input type="file" id="imageFileInput" name="images[]" accept="image/*" multiple style="display: none;" onchange="handleFilesSelected(this.files)">
                                    <i class="bi bi-cloud-arrow-up-fill upload-icon"></i>
                                    <h5 class="fw-bold mb-1">Click to browse or drag & drop up to 10 images here</h5>
                                    <p class="text-secondary small mb-2">Supported formats: JPG, PNG, WEBP, GIF</p>
                                    <span class="batch-limit-pill">
                                        <i class="bi bi-info-circle"></i> Batch Limit: 1 to 10 images at a time
                                    </span>
                                </div>

                                <!-- Multi-Image Preview Container -->
                                <div id="previewWrapper" class="preview-wrapper">
                                    <div class="preview-header">
                                        <span class="fw-bold text-warning small">
                                            <i class="bi bi-check2-all me-1"></i> <span id="selectedCountText">0 / 10 Images Selected</span>
                                        </span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllSelectedFiles()">
                                            <i class="bi bi-trash3 me-1"></i> Clear All
                                        </button>
                                    </div>
                                    <div id="previewGrid" class="preview-grid"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="imageTitle" class="form-label">Base Title / Project Name (Optional)</label>
                                <input type="text" class="form-control" id="imageTitle" name="title" placeholder="e.g. Commercial Shoot, Automotive Showcase">
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" id="btnUploadSubmit" class="btn-gold">
                                    <i class="bi bi-upload"></i> <span id="btnUploadText">Upload to Projects</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- TAB 3: SETTINGS -->
        <section id="tab-settings" class="tab-pane-content" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Account Settings -->
                    <div class="admin-card">
                        <h4 class="card-header-title">
                            <i class="bi bi-shield-lock text-warning"></i> Admin Credentials Settings
                        </h4>
                        <p class="text-secondary small mb-4">Change your admin email and password for accessing this portal</p>

                        <form id="settingsForm">
                            <div class="mb-3">
                                <label for="adminEmailInput" class="form-label">Admin Email Address</label>
                                <input type="email" class="form-control" id="adminEmailInput" name="email" value="<?= htmlspecialchars($adminEmail) ?>" required>
                            </div>

                            <hr class="border-secondary my-4">

                            <h6 class="fw-bold mb-3 text-warning">Change Password</h6>

                            <div class="mb-3">
                                <label for="currentPasswordInput" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="currentPasswordInput" name="current_password" placeholder="Enter current password to verify">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="newPasswordInput" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPasswordInput" name="new_password" placeholder="Minimum 6 characters">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmPasswordInput" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPasswordInput" name="confirm_password" placeholder="Re-enter new password">
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" id="btnSaveSettings" class="btn-gold">
                                    <i class="bi bi-check2-circle"></i> Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Custom Delete Confirmation Modal Popup -->
    <div id="deleteModal" class="custom-modal-backdrop" onclick="handleModalBackdropClick(event)">
        <div class="custom-modal-box">
            <div class="modal-icon-circle">
                <i class="bi bi-trash3-fill"></i>
            </div>
            <h4 class="fw-bold mb-2">Delete Project Image?</h4>
            <p class="text-secondary small mb-3">Are you sure you want to delete this image? It will be permanently removed from Cloudinary and your website gallery.</p>
            
            <img id="modalImgPreview" class="modal-preview-thumb" src="" alt="Delete Preview">
            <div id="modalImgTitle" class="fw-semibold small text-truncate mb-3 text-light"></div>

            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" id="btnConfirmDelete" class="btn-modal-delete" onclick="executeDelete()">
                    <i class="bi bi-trash3 me-1"></i> Delete Image
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notifications Container -->
    <div id="toastContainer"></div>

    <script>
        let sortableInstance = null;
        let selectedFilesArray = []; // Stores Array of File objects (up to 10)
        let pendingDeleteId = null;
        let pendingDeleteCard = null;

        // Tab Switching
        function switchTab(tabId, btnElement) {
            document.querySelectorAll('.tab-pane-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.admin-tab-btn').forEach(btn => btn.classList.remove('active'));
            
            document.getElementById(tabId).style.display = 'block';
            if (btnElement) btnElement.classList.add('active');

            if (tabId === 'tab-gallery') {
                loadGallery();
            }
        }

        // Toast notification helper
        function showToast(message, isSuccess = true) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-msg';
            toast.style.borderColor = isSuccess ? 'rgba(16, 185, 129, 0.4)' : 'rgba(239, 68, 68, 0.4)';
            toast.innerHTML = `
                <i class="bi ${isSuccess ? 'bi-check-circle-fill text-success' : 'bi-exclamation-triangle-fill text-danger'} fs-5"></i>
                <div class="small font-medium">${message}</div>
            `;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        // Load Gallery Images
        async function loadGallery() {
            const container = document.getElementById('galleryContainer');
            container.innerHTML = `
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div class="spinner-border text-warning" role="status"></div>
                    <p class="mt-3">Loading images...</p>
                </div>
            `;

            try {
                const res = await fetch('api.php?action=list');
                const data = await res.json();

                if (!data.success) {
                    container.innerHTML = `
                        <div class="empty-state" style="grid-column: 1/-1;">
                            <i class="bi bi-database-exclamation"></i>
                            <h5>${data.error || 'Unable to load images'}</h5>
                            <p class="small text-secondary">Please check your database connection in .env</p>
                        </div>
                    `;
                    return;
                }

                if (!data.items || data.items.length === 0) {
                    container.innerHTML = `
                        <div class="empty-state" style="grid-column: 1/-1;">
                            <i class="bi bi-images"></i>
                            <h5>No images uploaded yet</h5>
                            <p class="small text-secondary">Click "Upload Images" to add images to Cloudinary & Projects!</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = data.items.map((item, index) => `
                    <div class="gallery-item-card" data-id="${item.id}" id="card-img-${item.id}">
                        <div class="order-badge">#<span class="order-num">${index + 1}</span></div>
                        <div class="drag-indicator" title="Drag to reorder">
                            <i class="bi bi-grip-vertical"></i>
                        </div>
                        <div class="gallery-item-thumb">
                            <img src="${item.image_url}" alt="${escapeHtml(item.title || 'Mineshot Project Image')}" loading="lazy">
                        </div>
                        <div class="gallery-item-body">
                            <div class="gallery-item-title" title="${escapeHtml(item.title || 'Project Image')}">
                                ${escapeHtml(item.title || 'Project Image')}
                            </div>
                            <button class="btn-delete" onclick="openDeleteModal(event, ${item.id}, '${escapeHtml(item.image_url)}', '${escapeHtml(item.title || 'Project Image')}')">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                        </div>
                    </div>
                `).join('');

                initSortable();

            } catch (err) {
                container.innerHTML = `
                    <div class="empty-state" style="grid-column: 1/-1;">
                        <i class="bi bi-exclamation-octagon text-danger"></i>
                        <h5>Error loading gallery</h5>
                        <p class="small text-secondary">${err.message}</p>
                    </div>
                `;
            }
        }

        // Initialize SortableJS for Drag and Drop
        function initSortable() {
            const container = document.getElementById('galleryContainer');
            if (!container) return;

            if (sortableInstance) {
                sortableInstance.destroy();
            }

            if (typeof Sortable !== 'undefined') {
                sortableInstance = new Sortable(container, {
                    animation: 200,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    handle: '.gallery-item-card',
                    onEnd: function() {
                        updateOrderNumbers();
                        saveOrder();
                    }
                });
            } else {
                initNativeDragDrop();
            }
        }

        function updateOrderNumbers() {
            const badges = document.querySelectorAll('#galleryContainer .order-num');
            badges.forEach((badge, idx) => {
                badge.textContent = idx + 1;
            });
        }

        // Save reordered array to server
        async function saveOrder() {
            const cards = document.querySelectorAll('#galleryContainer .gallery-item-card');
            const order = Array.from(cards).map(card => card.getAttribute('data-id'));

            if (order.length === 0) return;

            const formData = new FormData();
            formData.append('order', JSON.stringify(order));

            try {
                const res = await fetch('api.php?action=reorder', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Gallery order updated successfully!');
                } else {
                    showToast(data.error || 'Failed to update order', false);
                }
            } catch (err) {
                showToast('Reorder error: ' + err.message, false);
            }
        }

        // Native HTML5 Drag & Drop Fallback
        function initNativeDragDrop() {
            const cards = document.querySelectorAll('#galleryContainer .gallery-item-card');
            let dragSrcEl = null;

            cards.forEach(card => {
                card.setAttribute('draggable', 'true');
                card.addEventListener('dragstart', function(e) {
                    dragSrcEl = this;
                    e.dataTransfer.effectAllowed = 'move';
                    this.classList.add('sortable-ghost');
                });
                card.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    return false;
                });
                card.addEventListener('drop', function(e) {
                    e.stopPropagation();
                    if (dragSrcEl !== this) {
                        const container = document.getElementById('galleryContainer');
                        const allCards = Array.from(container.children);
                        const srcIndex = allCards.indexOf(dragSrcEl);
                        const targetIndex = allCards.indexOf(this);
                        if (srcIndex < targetIndex) {
                            this.after(dragSrcEl);
                        } else {
                            this.before(dragSrcEl);
                        }
                        updateOrderNumbers();
                        saveOrder();
                    }
                    return false;
                });
                card.addEventListener('dragend', function() {
                    this.classList.remove('sortable-ghost');
                });
            });
        }

        function escapeHtml(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        // --- Custom Delete Modal Functions ---
        function openDeleteModal(event, id, imgUrl, title) {
            if (event) event.stopPropagation();
            pendingDeleteId = id;
            pendingDeleteCard = document.getElementById(`card-img-${id}`);

            document.getElementById('modalImgPreview').src = imgUrl;
            document.getElementById('modalImgTitle').textContent = title || 'Project Image';
            
            const modal = document.getElementById('deleteModal');
            modal.classList.add('show');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');
            pendingDeleteId = null;
            pendingDeleteCard = null;
        }

        function handleModalBackdropClick(e) {
            if (e.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDeleteModal();
        });

        async function executeDelete() {
            if (!pendingDeleteId) return;

            const btn = document.getElementById('btnConfirmDelete');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Deleting...`;

            const card = pendingDeleteCard;
            if (card) {
                card.style.opacity = '0.3';
                card.style.pointerEvents = 'none';
            }

            const formData = new FormData();
            formData.append('id', pendingDeleteId);

            try {
                const res = await fetch('api.php?action=delete', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    showToast('Image successfully deleted!');
                    if (card) card.remove();
                    updateOrderNumbers();
                    closeDeleteModal();

                    const container = document.getElementById('galleryContainer');
                    if (container.children.length === 0) {
                        loadGallery();
                    }
                } else {
                    showToast(data.error || 'Failed to delete image', false);
                    if (card) {
                        card.style.opacity = '1';
                        card.style.pointerEvents = 'auto';
                    }
                }
            } catch (err) {
                showToast('Error deleting image: ' + err.message, false);
                if (card) {
                    card.style.opacity = '1';
                    card.style.pointerEvents = 'auto';
                }
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        }

        // --- Multi-Image File Selection Handling (Max 10) ---
        function handleFilesSelected(files) {
            if (!files || files.length === 0) return;

            const incomingList = Array.from(files);
            const remainingSlots = 10 - selectedFilesArray.length;

            if (remainingSlots <= 0) {
                showToast('Maximum 10 images limit reached. Remove some to add new ones.', false);
                return;
            }

            if (incomingList.length > remainingSlots) {
                showToast(`You can upload at most 10 images at a time. Only the first ${remainingSlots} images were added.`, false);
            }

            const allowedToAdd = incomingList.slice(0, remainingSlots);
            selectedFilesArray = selectedFilesArray.concat(allowedToAdd);

            renderPreviewGrid();
        }

        function removeSelectedFile(index) {
            selectedFilesArray.splice(index, 1);
            renderPreviewGrid();
        }

        function clearAllSelectedFiles() {
            selectedFilesArray = [];
            document.getElementById('imageFileInput').value = '';
            document.getElementById('previewWrapper').style.display = 'none';
            document.getElementById('dropzone').style.display = 'block';
            document.getElementById('btnUploadText').textContent = 'Upload to Projects';
        }

        function renderPreviewGrid() {
            const grid = document.getElementById('previewGrid');
            const wrapper = document.getElementById('previewWrapper');
            const countText = document.getElementById('selectedCountText');
            const btnText = document.getElementById('btnUploadText');

            if (selectedFilesArray.length === 0) {
                clearAllSelectedFiles();
                return;
            }

            wrapper.style.display = 'block';
            countText.textContent = `${selectedFilesArray.length} / 10 Images Selected`;
            btnText.textContent = `Upload ${selectedFilesArray.length} Image${selectedFilesArray.length > 1 ? 's' : ''} to Projects`;

            grid.innerHTML = '';
            selectedFilesArray.forEach((file, index) => {
                const card = document.createElement('div');
                card.className = 'preview-card';

                const img = document.createElement('img');
                img.alt = file.name;
                const reader = new FileReader();
                reader.onload = (e) => { img.src = e.target.result; };
                reader.readAsDataURL(file);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-btn';
                removeBtn.innerHTML = '&times;';
                removeBtn.title = 'Remove this image';
                removeBtn.onclick = () => removeSelectedFile(index);

                const badge = document.createElement('span');
                badge.className = 'preview-card-index';
                badge.textContent = `#${index + 1}`;

                card.appendChild(img);
                card.appendChild(removeBtn);
                card.appendChild(badge);
                grid.appendChild(card);
            });
        }

        // Drag and Drop for Upload Zone
        const dropzone = document.getElementById('dropzone');
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                handleFilesSelected(files);
            }
        });

        // Upload Form Submit
        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (selectedFilesArray.length === 0) {
                showToast('Please select at least one image file to upload (Max 10)', false);
                return;
            }

            if (selectedFilesArray.length > 10) {
                showToast('Maximum 10 images can be uploaded at a time.', false);
                return;
            }

            const btn = document.getElementById('btnUploadSubmit');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span> Uploading ${selectedFilesArray.length} image(s)...`;

            const formData = new FormData();
            const titleVal = document.getElementById('imageTitle').value;
            formData.append('title', titleVal);

            selectedFilesArray.forEach((file) => {
                formData.append('images[]', file);
            });

            try {
                const res = await fetch('api.php?action=upload', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    showToast(data.message || 'Images uploaded successfully to Projects Gallery!');
                    this.reset();
                    clearAllSelectedFiles();
                    setTimeout(() => {
                        switchTab('tab-gallery', document.querySelectorAll('.admin-tab-btn')[0]);
                    }, 500);
                } else {
                    showToast(data.error || 'Upload failed', false);
                }
            } catch (err) {
                showToast('Upload error: ' + err.message, false);
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
            }
        });

        // Settings Form Submit
        document.getElementById('settingsForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('btnSaveSettings');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span> Saving...`;

            const formData = new FormData(this);

            try {
                const res = await fetch('api.php?action=update_settings', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    showToast(data.message || 'Settings updated successfully!');
                    document.getElementById('currentPasswordInput').value = '';
                    document.getElementById('newPasswordInput').value = '';
                    document.getElementById('confirmPasswordInput').value = '';
                } else {
                    showToast(data.error || 'Failed to update settings', false);
                }
            } catch (err) {
                showToast('Settings error: ' + err.message, false);
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
            }
        });

        // Initial load
        loadGallery();
    </script>
</body>
</html>
