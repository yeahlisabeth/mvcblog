<nav class="top-nav">
    <ul>
        <li>
            <?php if (isLoggedIn()): ?>
                <a href="<?php echo URLROOT; ?>/posts/create">post</a>
            <?php endif; ?>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/index">home</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/posts">blog</a>
        </li>
        <li class="btn-login">
            <?php if(isLoggedIn()) : ?>
            <a href="<?php echo URLROOT; ?>/users/logout">logout</a>
            <?php else : ?>
            <a href="<?php echo URLROOT; ?>/users/login">login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>