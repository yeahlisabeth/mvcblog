<?php
require APPROOT . '/views/includes/head.php';
?>

<div class="navbar dark">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">
    <br>
    <?php if (isLoggedIn()): ?>
    <a class="btn create" href="<?php echo URLROOT; ?>/posts/create">create</a>
    <?php endif; ?>
    <?php foreach($data['posts'] as $post): ?>
    <br>
    <br>
    <div class="container-item">
        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id): ?>
            <a
                    class="btn update"
                    href="<?php echo URLROOT . '/posts/update/' . $post->id ?>">
                update
            </a>
            <form action="<?php echo URLROOT . '/posts/delete/' . $post->id ?>" method="POST">
                <input type="submit" name="delete" value="delete" class="btn delete">
            </form>
        <?php endif; ?>
        <h2>
            <?php echo $post->title; ?>
        </h2>

        <h3>
            <?php echo 'Created on: ' . date('F j h:m', strtotime($post->created_at)) ?>
        </h3>

        <p>
            <?php echo $post->body ?>
        </p>
    </div>
    <?php endforeach; ?>
</div>