<?php
include_once __DIR__ . '/includes/globals.php';
include_once __DIR__.'/includes/User.php';

$user = \DataHandle\User::selectUser($_SESSION['userId']);


?>

<div class="user-profile">
    <img class="user-img" src="<?php echo $user['image']?>" alt="user">
    <h1 class="username"><?php echo $user['username'];?></h1>    
    <p class="user-bio"><?php echo $user['bio'];?></p>
    <a href="/includes/edit-profile.php"><i class="far fa-edit"></i></a>
</div>
<div class="user-buttons">
    <a href="/includes/manage-profile.php?password=1" class="btn btn-dark">Change Password</a>
    <a href="/includes/manage-profile.php?delete=1" class="btn btn-dark">Delete account</a>

</div>


</body>
</html>