<?php
$links = [
    'Home' => '/expenss',
    'Dashboard' => '/expenss/dashboard.php',
    'Login' => '/expenss/auth/login.php',
    'Register' => '/expenss/auth/register.php',
    'Logout' => '/expenss/auth/logout.php',
]
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark container-fluid">
    <div class="container-fluid">
        <a class="navbar-brand" href="/expenss">Expenses</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/expenss">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/expenss/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/expenss/groups.php">Groups</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo $links['Login']; ?>">Login</a></li>
                        <li><a class="dropdown-item" href="<?php echo $links['Register']; ?>">Register</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo $links['Logout']; ?>">Log Out</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mx-lg-5 mb-2 mb-lg-0">
                <?php
                if ($islogedin) {
                    echo '<li class="nav-item">
                        <a class="nav-link disabled text-white fw-bold" href="#" tabindex="-1" aria-disabled="true">' . $_COOKIE['namee'] . '</a>
                        </li>';
                } else {
                    echo '<li class="nav-item">
                        <a class="nav-link text-primary " href="'.$links['Login'].'" tabindex="-1" >Login</a>
                        </li>';
                }
                ?>
            </ul>

        </div>
    </div>
</nav>