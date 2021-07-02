<?php

include_once __DIR__ . '/includes/globals.php';


if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert('Created', $_GET['stato']);

}  


?>
<div class="post-create">
    <h2>Create new post</h2>
    <form action="/blog/includes/create-post.php" method="POST" >
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="summary" class="form-label">Summary</label>
            <input type="text" name="summary" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea  type="textarea" name="content" class="form-control" autocomplete="off" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" name="image" placeholder="https://" class="form-control" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="publish" class="form-label">Publish</label>
            <input type="checkbox" name="publish" >
        </div>
        
        <input type="submit" value="Create post" class="btn btn-dark">
        
    </form>


</div>
</main>
</body>