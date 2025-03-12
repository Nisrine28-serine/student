<?php
require_once 'config.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Al Akhawayn University International Student Portal - Administrative Dashboard">
    <title>Al Akhawayn University - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <script src="cacheSidbar.js"></script>
    <style>
        body.sidebar-collapsed .sidebar {
            transform: translateX(-250px);
            width: 0;
            overflow: hidden;
            visibility: hidden;
            /* Assure qu'il est complètement caché */
            opacity: 0;
            /* Ajout de l'opacité à 0 pour une disparition complète */
            pointer-events: none;
            /* Désactive les interactions pendant qu'il est caché */
        }


        body.sidebar-collapsed .main-content {
            margin-left: 0;
            width: 100%;
        }

        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 250px;
            z-index: 1001;
            background-color: #0d6efd;
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: left 0.3s ease-in-out;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        body.sidebar-collapsed .sidebar-toggle {
            left: 0;
        }

        body.sidebar-collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease-in-out;
            overflow-x: hidden;
        }

        body.sidebar-collapsed .sidebar {
            transform: translateX(-250px);
            width: 0;
            overflow: hidden;
            visibility: hidden;
            /* Assure qu'il est complètement caché */
            opacity: 0;
            /* Ajout de l'opacité à 0 pour une disparition complète */
            pointer-events: none;
            /* Désactive les interactions pendant qu'il est caché */
        }

        .main-content {
            transition: margin-left 0.3s ease-in-out;
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0;
            width: 100%;
        }

        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 250px;
            z-index: 1001;
            background-color: rgb(144, 145, 146);
            color: white;
            border: none;
            width: 20px;
            height: 50px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: left 0.3s ease-in-out;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body data-page="<?php echo $page; ?>">
    <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
        <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-university me-2"></i>
            AUI PORTAL
        </div>
        <div class="nav flex-column">
            <div class="nav-item">
                <a class="nav-link <?= $page === 'dashboard' ? 'active' : '' ?>" href="?page=dashboard<?= isset($_GET['id_num']) ? '&id_num=' . htmlspecialchars($_GET['id_num']) : '' ?>">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link <?= $page === 'students' ? 'active' : '' ?>" href="?page=students<?= isset($_GET['id_num']) ? '&id_num=' . htmlspecialchars($_GET['id_num']) : '' ?>">
                    <i class="fas fa-user-graduate"></i>
                    Student Profile
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link <?= $page === 'candidacy' ? 'active' : '' ?>" href="?page=candidacy<?= isset($_GET['id_num']) ? '&id_num=' . htmlspecialchars($_GET['id_num']) : '' ?>">
                    <i class="fas fa-file-alt"></i>
                    Admission Status
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link <?= $page === 'academic' ? 'active' : '' ?>" href="?page=academic<?= isset($_GET['id_num']) ? '&id_num=' . htmlspecialchars($_GET['id_num']) : '' ?>">
                    <i class="fas fa-graduation-cap"></i>
                    Academic Records
                </a>
            </div>
            <div class="nav-item mt-auto" style="margin-top: auto;">
                <a class="nav-link logout-sidebar" href="index.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Log Out
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="header-left">
                <div class="logo-container">
                    <div class="logo">
                        <img src="image.jpg" alt="AUI Logo" class="university-logo">
                    </div>
                    <div class="header-title">
                        <h1>Al Akhawayn University</h1>
                        <span class="header-subtitle">Student Information System</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="search-container">
                    <form method="GET" action="" class="search-form">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="hidden" name="page" value="<?= htmlspecialchars($page) ?>">
                            <input type="text" name="search_term" class="search-input" placeholder="Search by ID, first or last name..." value="<?= isset($_GET['search_term']) ? htmlspecialchars($_GET['search_term']) : '' ?>" required>
                        </div>
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i>
                            <span>Search</span>
                        </button>
                    </form>
                </div>

                <div class="header-divider"></div>

                <a href="index.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Log Out
                </a>
            </div>
        </div>

        <?php
        if (isset($_GET['search_term'])) {
            $search_term = $_GET['search_term'];

            // Search for students using API instead of direct SQL
            $api_url = "api/students/search.php?term=" . urlencode($search_term);
            $response = file_get_contents($api_url);
            $matching_students = json_decode($response, true);

            // If multiple students match the search
            if (count($matching_students) > 1) {
                // Check if an exact ID was provided
                $exact_id_match = false;
                if (isset($_GET['exact_id']) && !empty($_GET['exact_id'])) {
                    $exact_id = $_GET['exact_id'];

                    // Get student by exact ID from API
                    $api_url = "api/students/get.php?id=" . urlencode($exact_id);
                    $response = file_get_contents($api_url);
                    $student_info = json_decode($response, true);

                    if ($student_info) {
                        $id_num = $student_info['ID_NUM'];
                        $exact_id_match = true;
                    }
                }

                // If no exact ID match was found, show suggestions
                if (!$exact_id_match) {
        ?>
                    <div class="suggestions-container">
                        <div class="suggestions-header">
                            <h2><i class="fas fa-users"></i> Several students found</h2>
                            <p>We found several students matching <strong><?= htmlspecialchars($search_term) ?></strong>.</p>
                            <p>Please select a student from the list below:</p>
                        </div>
                        <div class="suggestions-list">
                            <?php foreach ($matching_students as $student): ?>
                                <a href="?page=<?= htmlspecialchars($page) ?>&search_term=<?= htmlspecialchars($search_term) ?>&exact_id=<?= htmlspecialchars($student['ID_NUM']) ?>" class="suggestion-item">
                                    <div class="suggestion-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div class="suggestion-details">
                                        <div class="suggestion-name"><?= htmlspecialchars($student['FIRST_NAME'] . ' ' . $student['LAST_NAME']) ?></div>
                                        <div class="suggestion-id">ID: <?= htmlspecialchars($student['ID_NUM']) ?></div>
                                    </div>
                                    <div class="suggestion-action">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
            <?php
                    // Stop processing the page here
                    return;
                }
            } else if (count($matching_students) == 1) {
                // If only one student was found, use their ID directly
                $student_info = $matching_students[0];
                $id_num = $student_info['ID_NUM'];
            } else {
                // Try to search by exact ID
                $api_url = "api/students/get.php?id=" . urlencode($search_term);
                $response = file_get_contents($api_url);
                $student_info = json_decode($response, true);

                if ($student_info) {
                    $id_num = $student_info['ID_NUM'];
                } else {
                    // No student found
                    $id_num = $search_term; // Keep search term for display in "not found" message
                }
            }
            ?>

            <!-- Student Header Section -->
            <div class="student-header mb-4">
                <div class="student-id-card">
                    <div class="student-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="student-id">
                        <?php if (isset($student_info) && $student_info) : ?>
                            <div class="d-flex">
                                <div>
                                    <h2>Student ID</h2>
                                    <p><?= htmlspecialchars($id_num) ?></p>
                                </div>
                                <div class="student-name">
                                    <h2>Full Name</h2>
                                    <p><?= htmlspecialchars($student_info['FIRST_NAME'] . ' ' . $student_info['LAST_NAME']) ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="student-not-found">
                                <h2>Student not found</h2>
                                <p>No students matching <strong><?= htmlspecialchars($search_term) ?></strong> exist in our database.</p>
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Please check your search and try again, or contact the administrator.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <?php if (isset($student_info) && $student_info) : ?>
                    <div class="header-tabs">
                        <a href="?page=students&search_term=<?= $id_num ?>" class="header-tab <?= $page === 'students' ? 'active' : '' ?>">
                            <i class="fas fa-user"></i>
                            Personal Information
                        </a>
                        <a href="?page=academic&search_term=<?= $id_num ?>" class="header-tab <?= $page === 'academic' ? 'active' : '' ?>">
                            <i class="fas fa-graduation-cap"></i>
                            Academic Record
                        </a>
                        <a href="?page=candidacy&search_term=<?= $id_num ?>" class="header-tab <?= $page === 'candidacy' ? 'active' : '' ?>">
                            <i class="fas fa-file-alt"></i>
                            Application Details
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php } ?>

        <?php
        // Display content based on the current page
        if (isset($_GET['search_term'])) {
            $search_term = $_GET['search_term'];

            // Check if an exact ID was specified
            if (isset($_GET['exact_id']) && !empty($_GET['exact_id'])) {
                $search_term = $_GET['exact_id'];
            }

            // Check if student exists
            $api_url = "api/students/get.php?id=" . urlencode($search_term);
            $response = file_get_contents($api_url);
            $check_student = json_decode($response, true);

            if ($check_student) {
                $id_num = $check_student['ID_NUM'];
                $data = [];

                // Define the API endpoint and data to fetch based on the active page
                switch ($page) {
                    case 'students':
                        // Get student personal information from API
                        $api_url = "api/students/personal.php?id=" . urlencode($id_num);
                        $api_url .= isset($_GET['p']) ? "&page=" . urlencode($_GET['p']) : "";
                        $response = file_get_contents($api_url);
                        $api_data = json_decode($response, true);

                        $results = $api_data['results'];
                        $total = $api_data['total'];
                        $total_pages = $api_data['total_pages'];
                        $current_page = $api_data['current_page'];

                        $hasResults = !empty($results);
                        if ($hasResults) {
                            echo '<div class="student-container">';
                            echo '<div class="student-header">';
                            echo '<h2 class="student-title">Student Profile</h2>';
                            echo '<p class="student-subtitle">Personal Information</p>';
                            if ($total > 0) {
                                echo '<div class="records-counter"><i class="fas fa-database"></i> ' . $total . ' records found</div>';
                            }
                            echo '</div>';

                            echo '<div class="student-content">';
                            foreach ($results as $index => $row) {
                                echo '<div class="student-info-group">';
                                foreach ($row as $field => $value) {
                                    if ($value !== null && $value !== '') {
                                        echo '<div class="student-info-item">';
                                        echo '<div class="info-label">' . ucwords(str_replace('_', ' ', strtolower($field))) . '</div>';
                                        echo '<div class="info-value">' . htmlspecialchars($value) . '</div>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }
                            echo '</div>'; // Close student-content

                            if ($total_pages > 1) {
                                echo '<div class="pagination-container">';
                                // Previous button
                                $prev_page = $current_page - 1;
                                $prev_url = "?page=students&search_term=" . urlencode($id_num) . "&p=" . $prev_page;
                                echo '<a href="' . ($current_page > 1 ? $prev_url : '#') . '" class="pagination-button' . ($current_page <= 1 ? ' disabled' : '') . '"' . ($current_page <= 1 ? ' disabled' : '') . '>';
                                echo '<i class="fas fa-chevron-left"></i> Previous';
                                echo '</a>';

                                // Page numbers
                                echo '<div class="pagination-info">Page ' . $current_page . ' of ' . $total_pages . '</div>';

                                // Next button
                                $next_page = $current_page + 1;
                                $next_url = "?page=students&search_term=" . urlencode($id_num) . "&p=" . $next_page;
                                echo '<a href="' . ($current_page < $total_pages ? $next_url : '#') . '" class="pagination-button' . ($current_page >= $total_pages ? ' disabled' : '') . '"' . ($current_page >= $total_pages ? ' disabled' : '') . '>';
                                echo 'Next <i class="fas fa-chevron-right"></i>';
                                echo '</a>';
                                echo '</div>';
                            }

                            echo '</div>'; // Close student-container
                        }
                        break;

                    case 'candidacy':
                        // Get candidacy information from API
                        $api_url = "api/students/candidacy.php?id=" . urlencode($id_num);
                        $api_url .= isset($_GET['p']) ? "&page=" . urlencode($_GET['p']) : "";
                        $response = file_get_contents($api_url);
                        $api_data = json_decode($response, true);

                        $results = $api_data['results'];
                        $total = $api_data['total'];
                        $total_pages = $api_data['total_pages'];
                        $current_page = $api_data['current_page'];

                        $hasResults = !empty($results);
                        if ($hasResults) {
                            echo '<div class="student-container">';
                            echo '<div class="student-header">';
                            echo '<h2 class="student-title">Student Profile</h2>';
                            echo '<p class="student-subtitle">Application Details</p>';
                            if ($total > 0) {
                                echo '<div class="records-counter"><i class="fas fa-database"></i> ' . $total . ' records found</div>';
                            }
                            echo '</div>';

                            echo '<div class="student-content">';
                            foreach ($results as $index => $row) {
                                echo '<div class="student-info-group">';
                                foreach ($row as $field => $value) {
                                    if ($value !== null && $value !== '') {
                                        echo '<div class="student-info-item">';
                                        echo '<div class="info-label">' . ucwords(str_replace('_', ' ', strtolower($field))) . '</div>';
                                        echo '<div class="info-value">' . htmlspecialchars($value) . '</div>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }
                            echo '</div>'; // Close student-content

                            if ($total_pages > 1) {
                                echo '<div class="pagination-container">';
                                // Previous button
                                $prev_page = $current_page - 1;
                                $prev_url = "?page=candidacy&search_term=" . urlencode($id_num) . "&p=" . $prev_page;
                                echo '<a href="' . ($current_page > 1 ? $prev_url : '#') . '" class="pagination-button' . ($current_page <= 1 ? ' disabled' : '') . '"' . ($current_page <= 1 ? ' disabled' : '') . '>';
                                echo '<i class="fas fa-chevron-left"></i> Previous';
                                echo '</a>';

                                // Page numbers
                                echo '<div class="pagination-info">Page ' . $current_page . ' of ' . $total_pages . '</div>';

                                // Next button
                                $next_page = $current_page + 1;
                                $next_url = "?page=candidacy&search_term=" . urlencode($id_num) . "&p=" . $next_page;
                                echo '<a href="' . ($current_page < $total_pages ? $next_url : '#') . '" class="pagination-button' . ($current_page >= $total_pages ? ' disabled' : '') . '"' . ($current_page >= $total_pages ? ' disabled' : '') . '>';
                                echo 'Next <i class="fas fa-chevron-right"></i>';
                                echo '</a>';
                                echo '</div>';
                            }

                            echo '</div>'; // Close student-container
                        }
                        break;

                    case 'academic':
                        // Get academic records from API
                        $api_url = "api/students/academic.php?id=" . urlencode($id_num);
                        $api_url .= isset($_GET['p']) ? "&page=" . urlencode($_GET['p']) : "";
                        $response = file_get_contents($api_url);
                        $api_data = json_decode($response, true);

                        $results = $api_data['results'];
                        $total = $api_data['total'];
                        $total_pages = $api_data['total_pages'];
                        $current_page = $api_data['current_page'];

                        $hasResults = !empty($results);
                        if ($hasResults) {
                            echo '<div class="student-container">';
                            echo '<div class="student-header">';
                            echo '<h2 class="student-title">Student Profile</h2>';
                            echo '<p class="student-subtitle">Academic Record</p>';
                            if ($total > 0) {
                                echo '<div class="records-counter"><i class="fas fa-database"></i> ' . $total . ' records found</div>';
                            }
                            echo '</div>';

                            echo '<div class="student-content">';
                            foreach ($results as $index => $row) {
                                echo '<div class="student-info-group">';
                                foreach ($row as $field => $value) {
                                    if ($value !== null && $value !== '') {
                                        echo '<div class="student-info-item">';
                                        echo '<div class="info-label">' . ucwords(str_replace('_', ' ', strtolower($field))) . '</div>';
                                        echo '<div class="info-value">' . htmlspecialchars($value) . '</div>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }
                            echo '</div>'; // Close student-content

                            if ($total_pages > 1) {
                                echo '<div class="pagination-container">';
                                // Previous button
                                $prev_page = $current_page - 1;
                                $prev_url = "?page=academic&search_term=" . urlencode($id_num) . "&p=" . $prev_page;
                                echo '<a href="' . ($current_page > 1 ? $prev_url : '#') . '" class="pagination-button' . ($current_page <= 1 ? ' disabled' : '') . '"' . ($current_page <= 1 ? ' disabled' : '') . '>';
                                echo '<i class="fas fa-chevron-left"></i> Previous';
                                echo '</a>';

                                // Page numbers
                                echo '<div class="pagination-info">Page ' . $current_page . ' of ' . $total_pages . '</div>';

                                // Next button
                                $next_page = $current_page + 1;
                                $next_url = "?page=academic&search_term=" . urlencode($id_num) . "&p=" . $next_page;
                                echo '<a href="' . ($current_page < $total_pages ? $next_url : '#') . '" class="pagination-button' . ($current_page >= $total_pages ? ' disabled' : '') . '"' . ($current_page >= $total_pages ? ' disabled' : '') . '>';
                                echo 'Next <i class="fas fa-chevron-right"></i>';
                                echo '</a>';
                                echo '</div>';
                            }

                            echo '</div>'; // Close student-container
                        }
                        break;

                    default:
                        // Dashboard view - get summary data from API
                        $api_url = "api/students/dashboard.php?id=" . urlencode($id_num);
                        $response = file_get_contents($api_url);
                        $dashboard_data = json_decode($response, true);

                        $hasResults = false;
                        echo '<div class="dashboard-container">';

                        // Process and display each section of dashboard data
                        foreach ($dashboard_data as $section => $section_data) {
                            if (!empty($section_data['results'])) {
                                $hasResults = true;
                                echo '<div class="dashboard-card">';
                                echo '<div class="dashboard-card-header">';
                                echo '<i class="fas fa-' . $section_data['icon'] . '"></i>';
                                echo '<h3>' . $section_data['title'] . '</h3>';
                                echo '</div>';
                                echo '<div class="dashboard-card-content">';

                                foreach ($section_data['results'] as $result_index => $result) {
                                    if ($result_index > 0) {
                                        echo '<hr style="margin: 15px 0; border-top: 2px dashed rgba(0,0,0,0.1);">';
                                    }

                                    // Display fields in specified order first
                                    foreach ($section_data['order'] as $field) {
                                        if (isset($result[$field]) && $result[$field] !== null && $result[$field] !== '') {
                                            echo '<div class="dashboard-info-item">';
                                            echo '<div class="dashboard-label">' . ucwords(str_replace('_', ' ', strtolower($field))) . '</div>';
                                            echo '<div class="dashboard-value">' . htmlspecialchars($result[$field]) . '</div>';
                                            echo '</div>';
                                        }
                                    }

                                    // Then display remaining fields
                                    foreach ($result as $field => $value) {
                                        if (!in_array($field, $section_data['order']) && $value !== null && $value !== '') {
                                            echo '<div class="dashboard-info-item">';
                                            echo '<div class="dashboard-label">' . ucwords(str_replace('_', ' ', strtolower($field))) . '</div>';
                                            echo '<div class="dashboard-value">' . htmlspecialchars($value) . '</div>';
                                            echo '</div>';
                                        }
                                    }
                                }

                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                        break;
                }

                if (!$hasResults && $page !== 'dashboard') {
                    echo '<div class="alert alert-warning">
                <i class="fas fa-exclamation-circle me-2"></i>
                No results found for ID: ' . htmlspecialchars($id_num) . ' in this section
                </div>';
                }
            }
        }
        ?>
        <!-- Footer -->
        <footer class="page-footer">
            <p>&copy; <?= date('Y') ?> Al Akhawayn University - All Rights Reserved</p>
            <a href="https://www.aui.ma" target="_blank">Visit Website</a>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
        // Script to toggle sidebar visibility
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-collapsed');

            // Save sidebar state in localStorage
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        }

        // Load sidebar state from localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed) {
                document.body.classList.add('sidebar-collapsed');
            }
        });
    </script>
</body>

</html>