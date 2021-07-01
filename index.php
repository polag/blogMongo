<?php
include_once __DIR__ . '/includes/header.php';
include_once __DIR__ . '/includes/FormHandle.php';
include_once __DIR__ . '/includes/Posts.php';

$posts = \DataHandle\Posts::selectPost();
?>

<div class="post-container">
    <h1>ALL POSTS</h1>
    <div class="row">
        <?php foreach ($posts as $post) : ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <?php if ($_SESSION['userId'] == $post['author_id']) : ?>
                    <a href="/blog/post-view.php?id=<?php echo $post['id'] ?>&comment=0">
                    <?php else : ?>
                        <a href="/blog/post-view.php?id=<?php echo $post['id'] ?>&comment=1">
                        <?php endif; ?>
                        <div class="card post-card">
                            <img class="preview-img" src="<?php echo $post['image'] ?>" alt="post">
                            <div class="card-body">
                                <p><?php echo date('d M Y', strtotime($post['created_at'])) ?></p>
                                <h2 class="post-title"><?php echo $post['title'] ?></h2>
                                <h3 class="post-author">By <?php echo $post['username'] ?></h3>
                                <p class="post-summary"><?php echo $post['summary'] ?></p>
                            </div>
                        </div>
                        </a>
            </div>

        <?php endforeach; ?>
    </div>
    </main>

    </body>

    </html>