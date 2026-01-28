<?php
require_once __DIR__ . 'config.php'; 
?>

 <?php
    $posts = lade_bluesky_feed('YOURNAME.bsky.social', LIMIT);
    ?>
    <?php if (!$posts): ?>
        <p class="x-empty">No Post</p>
    <?php endif; ?>
    <?php foreach ($posts as $post): ?>
        <div class="quicknews-container">
            <div class="quicknews-header"><?= $post['date'] ?></div>
            <div class="quicknews-content">
                <div class="scrolling-text">
                    <?= nl2br(text_mit_links($post['text'])) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
