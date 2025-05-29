<?php
session_start();

include "models.php";
// Mock Data Setup
class MockData
{
    public static function getWorkers()
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'John Smith',
                'category' => 'Plumber',
                'phone' => '+1-555-0101',
                'location' => 'Downtown',
                'introduction' => 'Professional plumber with 8+ years of experience. Specializing in residential and commercial plumbing repairs.',
                'experience' => '8 years',
                'rating' => 4.8,
                'reviews_count' => 47,
                'available' => true,
                'hourly_rate' => 75
            ],
            2 => [
                'id' => 2,
                'name' => 'Sarah Johnson',
                'category' => 'Electrician',
                'phone' => '+1-555-0102',
                'location' => 'Midtown',
                'introduction' => 'Licensed electrician providing safe and reliable electrical services for homes and businesses.',
                'experience' => '6 years',
                'rating' => 4.9,
                'reviews_count' => 32,
                'available' => true,
                'hourly_rate' => 80
            ],
            3 => [
                'id' => 3,
                'name' => 'Mike Wilson',
                'category' => 'Carpenter',
                'phone' => '+1-555-0103',
                'location' => 'Uptown',
                'introduction' => 'Custom woodwork and furniture repair specialist. Quality craftsmanship guaranteed.',
                'experience' => '12 years',
                'rating' => 4.7,
                'reviews_count' => 68,
                'available' => false,
                'hourly_rate' => 65
            ],
            4 => [
                'id' => 4,
                'name' => 'Lisa Brown',
                'category' => 'House Cleaner',
                'phone' => '+1-555-0104',
                'location' => 'Suburban',
                'introduction' => 'Thorough and reliable house cleaning services. Eco-friendly products used.',
                'experience' => '4 years',
                'rating' => 4.6,
                'reviews_count' => 89,
                'available' => true,
                'hourly_rate' => 45
            ],
            5 => [
                'id' => 5,
                'name' => 'David Garcia',
                'category' => 'Gardener',
                'phone' => '+1-555-0105',
                'location' => 'Garden District',
                'introduction' => 'Landscape maintenance and garden design expert. Transform your outdoor space.',
                'experience' => '10 years',
                'rating' => 4.8,
                'reviews_count' => 54,
                'available' => true,
                'hourly_rate' => 55
            ]
        ];
    }

    public static function getBookings()
    {
        return [
            1 => [
                'id' => 1,
                'user_name' => 'Alice Cooper',
                'worker_id' => 1,
                'service' => 'Kitchen sink repair',
                'date' => '2025-05-30',
                'time' => '10:00 AM',
                'status' => 'pending',
                'address' => '123 Main St, Downtown'
            ],
            2 => [
                'id' => 2,
                'user_name' => 'Bob Martin',
                'worker_id' => 1,
                'service' => 'Bathroom plumbing',
                'date' => '2025-06-01',
                'time' => '2:00 PM',
                'status' => 'confirmed',
                'address' => '456 Oak Ave, Downtown'
            ]
        ];
    }

    public static function getCategories()
    {
        return ['Plumber', 'Electrician', 'Carpenter', 'House Cleaner', 'Gardener', 'Mechanic', 'Painter'];
    }
}

// Handle form submissions
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'toggle_availability':
                $_SESSION['availability_status'] = $_POST['availability'] ?? 'off';
                break;
            case 'update_profile':
                $_SESSION['profile_updated'] = true;
                break;
            case 'respond_booking':
                $_SESSION['booking_response'] = $_POST['response'];
                break;
            case 'book_worker':
                $_SESSION['booking_success'] = true;
                break;
            case 'submit_rating':
                $_SESSION['rating_submitted'] = true;
                break;
        }
    }
}

// Get current page
$page = $_GET['page'] ?? 'home';
$user_type = $_GET['type'] ?? 'user';
$worker_id = $_GET['worker_id'] ?? ($_SESSION['worker_id'] ?? 1);

// Set session worker_id if not set
if (!isset($_SESSION['worker_id'])) {
    $_SESSION['worker_id'] = 1;
}

$workers = MockData::getWorkers();
$bookings = MockData::getBookings();
$categories = MockData::getCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Service Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .worker-card {
            transition: transform 0.2s;
        }

        .worker-card:hover {
            transform: translateY(-5px);
        }

        .rating-stars {
            color: #ffc107;
        }

        .availability-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin: 5px 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="?page=home">
                <i class="fas fa-tools me-2"></i>Local Service Finder
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?= $user_type === 'user' ? 'active' : '' ?>" href="?type=user&page=home">User
                    Dashboard</a>
                <a class="nav-link <?= $user_type === 'worker' ? 'active' : '' ?>"
                    href="?type=worker&page=dashboard">Worker Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <?php if ($user_type === 'worker'): ?>
                <!-- Worker Sidebar -->
                <div class="col-md-3 col-lg-2 px-0">
                    <div class="sidebar p-3">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-circle fa-3x text-white mb-2"></i>
                            <h5 class="text-white"><?= $workers[$worker_id]['name'] ?></h5>
                            <small class="text-white-50"><?= $workers[$worker_id]['category'] ?></small>
                        </div>
                        <nav class="nav flex-column">
                            <a class="nav-link <?= $page === 'dashboard' ? 'active' : '' ?>"
                                href="?type=worker&page=dashboard">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                            <a class="nav-link <?= $page === 'availability' ? 'active' : '' ?>"
                                href="?type=worker&page=availability">
                                <i class="fas fa-calendar-check me-2"></i>Availability
                            </a>
                            <a class="nav-link <?= $page === 'bookings' ? 'active' : '' ?>"
                                href="?type=worker&page=bookings">
                                <i class="fas fa-calendar-alt me-2"></i>Booking Requests
                            </a>
                            <a class="nav-link <?= $page === 'profile' ? 'active' : '' ?>" href="?type=worker&page=profile">
                                <i class="fas fa-user me-2"></i>Manage Profile
                            </a>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Main Content -->
            <div class="<?= $user_type === 'worker' ? 'col-md-9 col-lg-10' : 'col-12' ?>">
                <div class="p-4">

                    <?php if ($user_type === 'user'): ?>
                        <?php if ($page === 'home' || $page === 'workers'): ?>
                            <!-- User Dashboard - Worker Listings -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2><i class="fas fa-search me-2"></i>Find Local Services</h2>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Filter by Category
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="?type=user&page=home">All Categories</a></li>
                                        <?php foreach ($categories as $category): ?>
                                            <li><a class="dropdown-item"
                                                    href="?type=user&page=home&category=<?= urlencode($category) ?>"><?= $category ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <?php if (isset($_SESSION['booking_success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="fas fa-check-circle me-2"></i>Booking request sent successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['booking_success']); ?>
                            <?php endif; ?>

                            <div class="row">
                                <?php
                                $filter_category = $_GET['category'] ?? null;
                                foreach ($workers as $worker):
                                    if ($filter_category && $worker['category'] !== $filter_category)
                                        continue;
                                    ?>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card worker-card h-100 position-relative">
                                            <span
                                                class="badge <?= $worker['available'] ? 'bg-success' : 'bg-secondary' ?> availability-badge">
                                                <?= $worker['available'] ? 'Available' : 'Busy' ?>
                                            </span>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-user-circle fa-3x text-primary me-3"></i>
                                                    <div>
                                                        <h5 class="card-title mb-0"><?= $worker['name'] ?></h5>
                                                        <small class="text-muted"><?= $worker['category'] ?></small>
                                                    </div>
                                                </div>

                                                <div class="mb-2">
                                                    <span class="rating-stars">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <i class="fas fa-star<?= $i <= floor($worker['rating']) ? '' : '-o' ?>"></i>
                                                        <?php endfor; ?>
                                                    </span>
                                                    <span class="ms-1"><?= $worker['rating'] ?> (<?= $worker['reviews_count'] ?>
                                                        reviews)</span>
                                                </div>

                                                <p class="card-text small"><?= substr($worker['introduction'], 0, 100) ?>...</p>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-success fw-bold">$<?= $worker['hourly_rate'] ?>/hr</span>
                                                    <small class="text-muted"><i class="fas fa-map-marker-alt"></i>
                                                        <?= $worker['location'] ?></small>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-grid gap-2">
                                                    <button class="btn btn-primary btn-sm" <?= !$worker['available'] ? 'disabled' : '' ?> onclick="showBookingModal(<?= $worker['id'] ?>)">
                                                        <i class="fas fa-calendar-plus me-1"></i>Book Service
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm"
                                                        onclick="showProfileModal(<?= $worker['id'] ?>)">
                                                        <i class="fas fa-eye me-1"></i>View Profile
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php elseif ($page === 'rating'): ?>
                            <!-- Rating Page -->
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4><i class="fas fa-star me-2"></i>Rate Service</h4>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isset($_SESSION['rating_submitted'])): ?>
                                                <div class="alert alert-success">
                                                    <i class="fas fa-check-circle me-2"></i>Thank you for your rating!
                                                </div>
                                                <?php unset($_SESSION['rating_submitted']); ?>
                                            <?php else: ?>
                                                <form method="POST">
                                                    <input type="hidden" name="action" value="submit_rating">
                                                    <div class="mb-3">
                                                        <label class="form-label">Rate your experience:</label>
                                                        <div class="rating-input">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>"
                                                                    required>
                                                                <label for="star<?= $i ?>" class="text-warning fs-4"><i
                                                                        class="fas fa-star"></i></label>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Review (optional):</label>
                                                        <textarea class="form-control" name="review" rows="3"
                                                            placeholder="Share your experience..."></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php else: // Worker Dashboard ?>

                        <?php if ($page === 'dashboard'): ?>
                            <!-- Worker Dashboard Overview -->
                            <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview</h2>

                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card text-center bg-primary text-white">
                                        <div class="card-body">
                                            <i class="fas fa-calendar-check fa-2x mb-2"></i>
                                            <h4>2</h4>
                                            <p>Pending Bookings</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center bg-success text-white">
                                        <div class="card-body">
                                            <i class="fas fa-star fa-2x mb-2"></i>
                                            <h4><?= $workers[$worker_id]['rating'] ?></h4>
                                            <p>Average Rating</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center bg-info text-white">
                                        <div class="card-body">
                                            <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                                            <h4>$<?= $workers[$worker_id]['hourly_rate'] ?></h4>
                                            <p>Hourly Rate</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center bg-warning text-white">
                                        <div class="card-body">
                                            <i class="fas fa-clock fa-2x mb-2"></i>
                                            <h4><?= $workers[$worker_id]['available'] ? 'Available' : 'Busy' ?></h4>
                                            <p>Current Status</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Bookings -->
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-history me-2"></i>Recent Booking Requests</h5>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($bookings)): ?>
                                        <p class="text-muted">No recent bookings.</p>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Service</th>
                                                        <th>Date & Time</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($bookings as $booking): ?>
                                                        <tr>
                                                            <td><?= $booking['user_name'] ?></td>
                                                            <td><?= $booking['service'] ?></td>
                                                            <td><?= date('M j, Y', strtotime($booking['date'])) ?> at
                                                                <?= $booking['time'] ?>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-<?= $booking['status'] === 'confirmed' ? 'success' : 'warning' ?>">
                                                                    <?= ucfirst($booking['status']) ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php elseif ($page === 'availability'): ?>
                            <!-- Availability Management -->
                            <h2><i class="fas fa-calendar-check me-2"></i>Manage Availability</h2>

                            <?php if (isset($_SESSION['availability_status'])): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="fas fa-check-circle me-2"></i>Availability status updated!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['availability_status']); ?>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Current Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST">
                                                <input type="hidden" name="action" value="toggle_availability">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" name="availability"
                                                        value="on" id="availabilityToggle" <?= $workers[$worker_id]['available'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="availabilityToggle">
                                                        I'm available for new bookings
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i>Update Status
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Status Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Current Status:</strong>
                                                <span
                                                    class="badge bg-<?= $workers[$worker_id]['available'] ? 'success' : 'secondary' ?>">
                                                    <?= $workers[$worker_id]['available'] ? 'Available' : 'Busy' ?>
                                                </span>
                                            </p>
                                            <p class="text-muted">
                                                When you're available, customers can see and book your services.
                                                When you're busy, your profile will be marked as unavailable.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php elseif ($page === 'bookings'): ?>
                            <!-- Booking Requests Management -->
                            <h2><i class="fas fa-calendar-alt me-2"></i>Booking Requests</h2>

                            <?php if (isset($_SESSION['booking_response'])): ?>
                                <div class="alert alert-info alert-dismissible fade show">
                                    <i class="fas fa-info-circle me-2"></i>Booking request <?= $_SESSION['booking_response'] ?>!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['booking_response']); ?>
                            <?php endif; ?>

                            <div class="row">
                                <?php foreach ($bookings as $booking): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Booking Request #<?= $booking['id'] ?></h6>
                                                <span
                                                    class="badge bg-<?= $booking['status'] === 'confirmed' ? 'success' : 'warning' ?>">
                                                    <?= ucfirst($booking['status']) ?>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Customer:</strong> <?= $booking['user_name'] ?></p>
                                                <p><strong>Service:</strong> <?= $booking['service'] ?></p>
                                                <p><strong>Date & Time:</strong> <?= date('M j, Y', strtotime($booking['date'])) ?>
                                                    at <?= $booking['time'] ?></p>
                                                <p><strong>Address:</strong> <?= $booking['address'] ?></p>

                                                <?php if ($booking['status'] === 'pending'): ?>
                                                    <div class="d-flex gap-2">
                                                        <form method="POST" class="flex-fill">
                                                            <input type="hidden" name="action" value="respond_booking">
                                                            <input type="hidden" name="response" value="accepted">
                                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                                <i class="fas fa-check me-1"></i>Accept
                                                            </button>
                                                        </form>
                                                        <form method="POST" class="flex-fill">
                                                            <input type="hidden" name="action" value="respond_booking">
                                                            <input type="hidden" name="response" value="declined">
                                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                                <i class="fas fa-times me-1"></i>Decline
                                                            </button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php elseif ($page === 'profile'): ?>
                            <!-- Profile Management -->
                            <h2><i class="fas fa-user me-2"></i>Manage Profile</h2>

                            <?php if (isset($_SESSION['profile_updated'])): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="fas fa-check-circle me-2"></i>Profile updated successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['profile_updated']); ?>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Profile Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST">
                                                <input type="hidden" name="action" value="update_profile">

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="<?= $workers[$worker_id]['name'] ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="tel" class="form-control" name="phone"
                                                            value="<?= $workers[$worker_id]['phone'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Service Category</label>
                                                        <select class="form-select" name="category" required>
                                                            <?php foreach ($categories as $category): ?>
                                                                <option value="<?= $category ?>"
                                                                    <?= $workers[$worker_id]['category'] === $category ? 'selected' : '' ?>>
                                                                    <?= $category ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Location</label>
                                                        <input type="text" class="form-control" name="location"
                                                            value="<?= $workers[$worker_id]['location'] ?>" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Introduction</label>
                                                    <textarea class="form-control" name="introduction" rows="3"
                                                        required><?= $workers[$worker_id]['introduction'] ?></textarea>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Years of Experience</label>
                                                        <input type="text" class="form-control" name="experience"
                                                            value="<?= $workers[$worker_id]['experience'] ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Hourly Rate ($)</label>
                                                        <input type="number" class="form-control" name="hourly_rate"
                                                            value="<?= $workers[$worker_id]['hourly_rate'] ?>" required>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i>Update Profile
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Profile Stats</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <strong>Current Rating:</strong>
                                                <div class="rating-stars">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i
                                                            class="fas fa-star<?= $i <= floor($workers[$worker_id]['rating']) ? '' : '-o' ?>"></i>
                                                    <?php endfor; ?>
                                                    <span class="ms-1"><?= $workers[$worker_id]['rating'] ?></span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Total Reviews:</strong> <?= $workers[$worker_id]['reviews_count'] ?>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Years of Experience:</strong> <?= $workers[$worker_id]['experience'] ?>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Total Bookings:</strong> 156
                                            </div>
                                            <div class="mb-3">
                                                <strong>Response Rate:</strong> 98%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="book_worker">
                    <input type="hidden" name="worker_id" id="modalWorkerId">
                    <div class="modal-body">
                        <div id="workerInfo" class="mb-3"></div>

                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="customer_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Service Required</label>
                            <input type="text" class="form-control" name="service"
                                placeholder="e.g., Kitchen sink repair" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Preferred Date</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preferred Time</label>
                                <select class="form-select" name="time" required>
                                    <option value="">Select Time</option>
                                    <option value="8:00 AM">8:00 AM</option>
                                    <option value="9:00 AM">9:00 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Your Address</label>
                            <textarea class="form-control" name="address" rows="2" placeholder="Enter your full address"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes (Optional)</label>
                            <textarea class="form-control" name="notes" rows="2"
                                placeholder="Any specific requirements or details"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Booking Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Worker Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="profileModalBody">
                    <!-- Profile content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="?type=user&page=rating" class="btn btn-warning">
                        <i class="fas fa-star me-1"></i>Rate This Worker
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const workers = <?= json_encode($workers) ?>;

        function showBookingModal(workerId) {
            const worker = workers[workerId];
            document.getElementById('modalWorkerId').value = workerId;
            document.getElementById('workerInfo').innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-3x text-primary me-3"></i>
                <div>
                    <h6 class="mb-0">${worker.name}</h6>
                    <small class="text-muted">${worker.category}</small>
                    <div class="text-success">${worker.hourly_rate}/hr</div>
                </div>
            </div>
        `;

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="date"]').setAttribute('min', today);

            new bootstrap.Modal(document.getElementById('bookingModal')).show();
        }

        function showProfileModal(workerId) {
            const worker = workers[workerId];
            const rating = worker.rating;
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<i class="fas fa-star${i <= Math.floor(rating) ? '' : '-o'} text-warning"></i>`;
            }

            document.getElementById('profileModalBody').innerHTML = `
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                    <h4>${worker.name}</h4>
                    <p class="text-muted">${worker.category}</p>
                    <div class="mb-2">${starsHtml} ${rating} (${worker.reviews_count} reviews)</div>
                    <div class="text-success fw-bold fs-5">${worker.hourly_rate}/hour</div>
                </div>
                <div class="col-md-8">
                    <h5>About</h5>
                    <p>${worker.introduction}</p>
                    
                    <div class="row">
                        <div class="col-6">
                            <h6><i class="fas fa-phone text-primary me-2"></i>Contact</h6>
                            <p>${worker.phone}</p>
                        </div>
                        <div class="col-6">
                            <h6><i class="fas fa-map-marker-alt text-primary me-2"></i>Location</h6>
                            <p>${worker.location}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <h6><i class="fas fa-briefcase text-primary me-2"></i>Experience</h6>
                            <p>${worker.experience}</p>
                        </div>
                        <div class="col-6">
                            <h6><i class="fas fa-clock text-primary me-2"></i>Availability</h6>
                            <p><span class="badge bg-${worker.available ? 'success' : 'secondary'}">${worker.available ? 'Available' : 'Busy'}</span></p>
                        </div>
                    </div>
                    
                    <h6>Sample Reviews</h6>
                    <div class="border-start ps-3 mb-2">
                        <div class="text-warning mb-1">★★★★★</div>
                        <p class="small mb-1">"Excellent work! Very professional and completed the job on time."</p>
                        <small class="text-muted">- Sarah M.</small>
                    </div>
                    <div class="border-start ps-3 mb-2">
                        <div class="text-warning mb-1">★★★★☆</div>
                        <p class="small mb-1">"Good service, fair pricing. Would recommend."</p>
                        <small class="text-muted">- John D.</small>
                    </div>
                </div>
            </div>
        `;

            new bootstrap.Modal(document.getElementById('profileModal')).show();
        }

        // Rating input functionality
        document.addEventListener('DOMContentLoaded', function () {
            const ratingInputs = document.querySelectorAll('.rating-input input');
            const ratingLabels = document.querySelectorAll('.rating-input label');

            ratingInputs.forEach((input, index) => {
                input.addEventListener('change', function () {
                    ratingLabels.forEach((label, labelIndex) => {
                        if (labelIndex <= index) {
                            label.style.color = '#ffc107';
                        } else {
                            label.style.color = '#e4e5e9';
                        }
                    });
                });
            });

            // Hover effects for rating
            ratingLabels.forEach((label, index) => {
                label.addEventListener('mouseenter', function () {
                    ratingLabels.forEach((l, i) => {
                        if (i <= index) {
                            l.style.color = '#ffc107';
                        } else {
                            l.style.color = '#e4e5e9';
                        }
                    });
                });
            });

            document.querySelector('.rating-input').addEventListener('mouseleave', function () {
                const checkedInput = document.querySelector('.rating-input input:checked');
                if (checkedInput) {
                    const checkedIndex = Array.from(ratingInputs).indexOf(checkedInput);
                    ratingLabels.forEach((label, labelIndex) => {
                        if (labelIndex <= checkedIndex) {
                            label.style.color = '#ffc107';
                        } else {
                            label.style.color = '#e4e5e9';
                        }
                    });
                } else {
                    ratingLabels.forEach(label => {
                        label.style.color = '#e4e5e9';
                    });
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

    <style>
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating-input input {
            display: none;
        }

        .rating-input label {
            cursor: pointer;
            color: #e4e5e9;
            transition: color 0.2s;
        }

        .rating-input label:hover,
        .rating-input label:hover~label {
            color: #ffc107 !important;
        }

        .rating-input input:checked~label {
            color: #ffc107;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: box-shadow 0.15s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }

            .container-fluid .row {
                margin: 0;
            }
        }
    </style>

</body>

</html>