<nav class="top-nav">
    <ul>
        <li>
            <a href="<?php echo URLROOT; ?>/pages/index">home</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/pages/about">about</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/pages/projects">projects</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/posts">blog</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/pages/contact">contact</a>
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