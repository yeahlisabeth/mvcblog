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
        <h2>register</h2>
        <form action="<?php echo URLROOT; ?>/users/register" method="POST">
            <input type="text" placeholder="username *" name="username">
            <span class="invalidFeedback">
                <?php echo $data['usernameError']; ?>
            </span>
            <input type="email" placeholder="email *" name="email">
            <span class="invalidFeedback">
                <?php echo $data['emailError']; ?>
            </span>
            <input type="password" placeholder="password *" name="password">
            <span class="invalidFeedback">
                <?php echo $data['passwordError']; ?>
            </span>
            <input type="password" placeholder="confirmPassword *" name="confirmPassword">
            <span class="invalidFeedback">
                <?php echo $data['confirmPasswordError']; ?>
            </span>
            <button id="submit" type="submit" value="submit">submit</button>
            <br>
            <p class="options">alreadyHaveAnAccount? <a href="<?php echo URLROOT; ?>/users/login">signIn</a></p>
        </form>
    </div>
</div>
