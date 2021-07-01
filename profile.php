<?php
include_once __DIR__ . '/includes/globals.php';
include_once __DIR__.'/includes/User.php';

$user = \DataHandle\User::selectUser($_SESSION['userId']);

if(isset($_GET['edit'])):?>
    <div class="edit-profile">
    <h2>Edit profile</h2>
    <form action="/blog/includes/edit-profile.php?id=<?php echo $user['id'];?>" method="POST" >
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $user['username'];?>"  autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo $user['firstname'];?>"  autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control" value="<?php echo $user['lastname'];?>"  autocomplete="off" required>        
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" value="<?php echo  $user['phone'];?>" class="form-control" autocomplete="off" >
        </div>
        <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
            <input type="text" name="email" value="<?php echo  $user['email'];?>" class="form-control" autocomplete="off" >
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" name="image" value="<?php echo$user['image'];?>" class="form-control" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Bio</label>
            <textarea type="text" name="bio"  class="form-control" autocomplete="off" ><?php echo  $user['bio'];?></textarea>
        </div>
        <input type="submit" value="Update profile" class="btn btn-dark">
        <a href="/blog/profile.php" class="btn btn-dark">Cancel</a>



    </form>

    <?php elseif(isset($_GET['password'])):?>
        <form action="/blog/includes/manage-profile.php?password=1" method="POST" >
            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" name="newPassword" class="form-control" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Old Password</label>
                <input type="password" name="password" class="form-control"  autocomplete="off" required>
            </div>
            <input type="submit" value="Update password" class="btn btn-dark">
            <a href="/blog/profile.php" class="btn btn-dark">Cancel</a>
        </form>


<?php else: ?>
<div class="user-profile">
    <img class="user-img" src="<?php echo $user['image']?>" alt="user">
    <h1 class="username"><?php echo $user['username'];?></h1>  
    <p><?php echo $user['firstname'].' '. $user['lastname'];?></p>  
    <p>Email: <?php echo $user['email'];?></p>
    <p>Phone: <?php echo $user['phone'];?></p>
    <p class="user-bio"><?php echo $user['bio'];?></p>
    <a href="/blog/profile.php?edit=1"><i class="far fa-edit"></i></a>
</div>
<div class="user-buttons">
    <a href="/blog/profile.php?password=1" class="btn btn-dark">Change Password</a>
    <a href="/blog/includes/manage-profile.php?delete=1" class="btn btn-dark">Delete account</a>

</div>
<?php endif; ?>

</body>
</html>