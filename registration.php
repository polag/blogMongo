<?php
require __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/util.php';
?>

    <h1>Sign Up</h1>
   <?php
    if (isset($_GET['stato'])) {
        \DataHandle\Utils\show_alert('registration', $_GET['stato']);
    }
    ?> 
    <form action="includes/registration.php" method="POST" class="container">
    <div class="col">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control" required>
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control" required>
        </div>
        
        <div class="col">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="col">
            <label for="email" class="form-label">E-mail Address</label>
            <input type="text" name="email" id="email" class="form-control" required>
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>
        <div class="col">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="col">
            <label for="password-check" class="form-label">Ripeti Password</label>
            <input type="password" name="password-check" id="password-check" class="form-control" required>
        </div>
        <input type="submit" value="Registrati" class="btn btn-dark">

    </form>

</main>
</body>

</html>
