<?php
include_once __DIR__ . '/includes/header.php';
include_once __DIR__.'/includes/FormHandle.php';
include_once __DIR__ . '/includes/Posts.php';

$posts = \DataHandle\Posts::selectPost();
?>

<div class="post-container">
<?php foreach($posts as $post): ?>
    <div class="item-container">
        <a href="/blog/post-view.php?id=<?php echo $post['id']?>&comment=1">
        <h2 class="post-title"><?php echo $post['title']?></h2>
        <h3 class="post-author">Author: <?php echo $post['username']?></h3>
        <img class="post-img" src="<?php echo $post['image']?>" alt="post">
        <p class="post-summary"><?php echo $post['summary']?></p>

        </a>

    </div>
    
    <?php endforeach;?>
</div> 
</main>

</body>

</html>