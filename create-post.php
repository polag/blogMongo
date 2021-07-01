<?php

include_once __DIR__ . '/includes/globals.php';


if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert('Created', $_GET['stato']);

}  


?>
<div>
    <h2>Add new post</h2>
    <form action="/blog/includes/create-post.php" method="POST">
        <input type="text" name="title" placeholder="Title" autocomplete="off" required>
        <input type="text" name="summary" placeholder="Summary" autocomplete="off" required>
        <input type="text" name="content" placeholder="Content" autocomplete="off" required>
        <input type="text" name="image" value="https://" autocomplete="off">
        <label for="publish">Publish</label>
        <input type="checkbox" name="publish">
        <input type="submit" value="Create post" class="btn btn-dark">

    </form>


</div>
</main>
</body>