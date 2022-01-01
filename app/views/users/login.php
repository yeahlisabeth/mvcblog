<?php
require APPROOT . '/views/includes/head.php';
?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>
<div class="container-login">
    <div class="wrapper-login">
        <h2>signIn</h2>
        <form action="<?php echo URLROOT; ?>/users/login" method="POST">
            <input type="text" placeholder="username *" name="username">
            <span class="invalidFeedback">
                <?php echo $data['usernameError']; ?>
            </span>
            <input type="password" placeholder="password *" name="password">
            <span class="invalidFeedback">
                <?php echo $data['passwordError']; ?>
            </span>
            <button id="submit" type="submit" value="submit">submit</button>
            <br>
            <p class="options">notRegisteredYet? <a href="<?php echo URLROOT; ?>/users/register">createAnAccount</a></p>
        </form>
    </div>
</div>