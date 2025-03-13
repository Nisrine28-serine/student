<?php
require_once 'config.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Function to make API requests more consistently
function callApi($endpoint, $params = [])
{
    $base_url = "https://students.aui.ma/api/get/student";
    $query_string = http_build_query($params);
    $url = $base_url . $endpoint . ($query_string ? "?id=" . $query_string : "");

    // Make the API request
    $response = @file_get_contents($url);

    if ($response === false) {
        // Handle API error
        return [
            'success' => false,
            'message' => 'Failed to connect to API',
            'results' => [],
            'total' => 0,
            'total_pages' => 0,
            'current_page' => 1
        ];
    }

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if JSON was valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'message' => 'Invalid API response',
            'results' => [],
            'total' => 0,
            'total_pages' => 0,
            'current_page' => 1
        ];
    }

    $data['success'] = true;
     echo "succ";
    // return $data;
}

// Function to get student by search term
function getStudentBySearch($search_term)
{
    return callApi('search.php', ['term' => $search_term]);
}

// Functi                       on to get student by ID
function getStudentById($id)
{
    return callApi('get.php', ['id' => $id]);
}

// Function to get student's personal info
function getStudentPersonalInfo($id, $page = null)
{
    $params = ['id' => $id];
    if ($page !== null) {
        $params['page'] = $page;
    }
    return callApi('personal.php', $params);
}

// Function to get student's candidacy info
function getStudentCandidacyInfo($id, $page = null)
{
    $params = ['id' => $id];
    if ($page !== null) {
        $params['page'] = $page;
    }
    return callApi('candidacy.php', $params);
}

// Function to get student's academic info
function getStudentAcademicInfo($id, $page = null)
{
    $params = ['id' => $id];
    if ($page !== null) {
        $params['page'] = $page;
    }
    return callApi('academic.php', $params);
}

// Function to get student's dashboard info
function getStudentDashboardInfo($id)
{
    return callApi('dashboard.php', ['id' => $id]);
}

// Handle search and get student ID
$student_info = null;
$id_num = null;

if (isset($_GET['search_term'])) {
    $search_term = $_GET['search_term'];

    // If exact ID is provided in URL
    if (isset($_GET['exact_id']) && !empty($_GET['exact_id'])) {
        $exact_id = $_GET['exact_id'];
        $student_response = getStudentById($exact_id);

        if ($student_response['success'] && !empty($student_response)) {
            $student_info = $student_response;
            $id_num = $student_info['ID_NUM'];
        }
    } else {
        // Search for students
        $matching_students = getStudentBySearch($search_term);

        // If only one student found
        if (count($matching_students) == 1) {
            $student_info = $matching_students[0];
            $id_num = $student_info['ID_NUM'];
        }
        // If multiple students found and no exact match specified
        else if (count($matching_students) > 1) {
            // Will show the multiple students UI
        }
        // If no students found by search term, try direct ID lookup
        else {
            $student_response = getStudentById($search_term);
            if ($student_response['success'] && !empty($student_response)) {
                $student_info = $student_response;
                $id_num = $student_info['ID_NUM'];
            } else {
                // No student found
                $id_num = $search_term; // Keep for display purposes
            }
        }
    }
}

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

            // If multiple students match the search
            if (isset($matching_students) && count($matching_students) > 1 && !isset($_GET['exact_id'])) {
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
        if (isset($_GET['search_term']) && isset($student_info) && $student_info) {
            $id_num = $student_info['ID_NUM'];
            $api_data = [];
            $hasResults = false;

            // Get the current page from URL, if present
            $current_p = isset($_GET['p']) ? intval($_GET['p']) : 1;

            // Define the API call based on the active page
            switch ($page) {
                case 'students':
                    $api_data = getStudentPersonalInfo($id_num, $current_p);
                    if ($api_data['success'] && !empty($api_data['results'])) {
                        displayStudentInfo(
                            $api_data,
                            "Student Profile",
                            "Personal Information",
                            $id_num,
                            $page
                        );
                        $hasResults = true;
                    }
                    break;

                case 'candidacy':
                    $api_data = getStudentCandidacyInfo($id_num, $current_p);
                    if ($api_data['success'] && !empty($api_data['results'])) {
                        displayStudentInfo(
                            $api_data,
                            "Student Profile",
                            "Application Details",
                            $id_num,
                            $page
                        );
                        $hasResults = true;
                    }
                    break;

                case 'academic':
                    $api_data = getStudentAcademicInfo($id_num, $current_p);
                    if ($api_data['success'] && !empty($api_data['results'])) {
                        displayStudentInfo(
                            $api_data,
                            "Student Profile",
                            "Academic Record",
                            $id_num,
                            $page
                        );
                        $hasResults = true;
                    }
                    break;

                default:
                    // Dashboard view
                    $dashboard_data = getStudentDashboardInfo($id_num);
                    if ($dashboard_data['success']) {
                        displayDashboard($dashboard_data, $id_num);
                        $hasResults = true;
                    }
                    break;
            }

            if (!$hasResults && $page !== 'dashboard') {
                echo '<div class="alert alert-warning">
            <i class="fas fa-exclamation-circle me-2"></i>
            No results found for ID: ' . htmlspecialchars($id_num) . ' in this section
            </div>';
            }
        }

        // Function to display student information with pagination
        function displayStudentInfo($api_data, $title, $subtitle, $id_num, $current_page)
        {
            $results = $api_data['results'];
            $total = $api_data['total'];
            $total_pages = $api_data['total_pages'];
            $current_page_num = $api_data['current_page'];

            echo '<div class="student-container">';
            echo '<div class="student-header">';
            echo '<h2 class="student-title">' . $title . '</h2>';
            echo '<p class="student-subtitle">' . $subtitle . '</p>';
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
                $prev_page = $current_page_num - 1;
                $prev_url = "?page=" . $current_page . "&search_term=" . urlencode($id_num) . "&p=" . $prev_page;
                echo '<a href="' . ($current_page_num > 1 ? $prev_url : '#') . '" class="pagination-button' . ($current_page_num <= 1 ? ' disabled' : '') . '"' . ($current_page_num <= 1 ? ' disabled' : '') . '>';
                echo '<i class="fas fa-chevron-left"></i> Previous';
                echo '</a>';

                // Page numbers
                echo '<div class="pagination-info">Page ' . $current_page_num . ' of ' . $total_pages . '</div>';

                // Next button
                $next_page = $current_page_num + 1;
                $next_url = "?page=" . $current_page . "&search_term=" . urlencode($id_num) . "&p=" . $next_page;
                echo '<a href="' . ($current_page_num < $total_pages ? $next_url : '#') . '" class="pagination-button' . ($current_page_num >= $total_pages ? ' disabled' : '') . '"' . ($current_page_num >= $total_pages ? ' disabled' : '') . '>';
                echo 'Next <i class="fas fa-chevron-right"></i>';
                echo '</a>';
                echo '</div>';
            }

            echo '</div>'; // Close student-container
        }

        // Function to display dashboard information
        function displayDashboard($dashboard_data, $id_num)
        {
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

            return $hasResults;
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