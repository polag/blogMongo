<?php
require __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/util.php';

?>

<h1>Accedi</h1>
    <?php
   
    if (isset($_GET['stato'])) {
        \DataHandle\Utils\show_alert('login', $_GET['stato']);
    }
    ?>
    <form action="includes/login.php" method="POST" class="container">
        <div class="col">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="col">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        
        <input type="submit" value="Login" class="btn btn-dark">

    </form>

</main>
</body>

</html>
