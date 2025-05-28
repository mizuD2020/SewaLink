<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .user-nav-item {
            margin-left: 20px;
        }

        .login-btn {
            padding: 8px 20px;
            background: #08c2f3;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: #069ccc;
            transform: translateY(-2px);
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            font-size: 16px;
            padding: 8px 0;
        }

        .user-btn i {
            font-size: 24px;
            vertical-align: middle;
            color: #08c2f3;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 4px;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="top-toolbar"><!--header toolbar-->
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
                        <div class="top-contact-info">
                            <ul>
                                <?php
                                $sql = "SELECT * from tblpage where PageType='contactus'";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) { ?>
                                        <li class="toolbar-email"><i class="fa fa-envelope-o"></i>
                                            <?php echo htmlentities($row->Email); ?></li>
                                        <li class="toolbar-contact"><i class="fa fa-phone"></i>
                                            +<?php echo htmlentities($row->MobileNumber); ?></li><?php $cnt = $cnt + 1;
                                    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--header toolbar end-->
        <div class="nav-wrapper"><!--main navigation-->
            <div class="container">
                <nav class="wsmenu slideLeft clearfix">
                    <div class="logo pull-left"><a href="index.php" title="Responsive Slide Menus">
                            <h3 style="color:#08c2f3">SEWALINK</h3>
                        </a></div>
                    <ul class="mobile-sub wsmenu-list pull-right">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="category.php">Categories</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact Us</a></li>

                        <?php if (isset($_SESSION['loggedin'])): ?>
                            <li class="user-nav-item user-dropdown">
                                <button class="user-btn">
                                    <i class="fas fa-user-circle"></i>
                                </button>
                                <div class="dropdown-content">
                                    <a href="#"><i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?></a>
                                    <a href="#"><i class="fas fa-envelope"></i> <?php echo $_SESSION['email'] ?? ''; ?></a>
                                    <a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="user-nav-item">
                                <a href="auth/login.php" class="login-btn">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!event.target.closest('.user-dropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].style.display = "none";
                }
            }
        });
    </script>
</body>

</html>