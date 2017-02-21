<?php $messages = $messages->get(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>LDAP</title>
    <link rel="stylesheet" href="assets/css/bulma.min.css"/>
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title">Change LDAP Password</h1>
        <?php if (!empty($messages['notification'])) { ?>
            <div class="notification <?= $messages['class'] ?>">
                <?= $messages['notification'] ?>
            </div>
        <?php } ?>
        <form action="change-password" name="passwordChange" method="POST">
            <label class="label">Username</label>
            <p class="control">
                <input class="input <?= !empty($messages['username']) ? 'is-danger' : ''; ?>"
                       type="text"
                       name="username"
                       id="username"
                       value="<?= !empty($postData['username']) ? $postData['username'] : '' ?>"
                >
                <?php if (!empty($messages['username'])) { ?>
                    <span class="help is-danger"><?= $messages['username'] ?></span>
                <?php } ?>
            </p>

            <label class="label">Old Password</label>
            <p class="control">
                <input class="input <?= !empty($messages['oldPassword']) ? 'is-danger' : ''; ?>"
                       type="password"
                       name="oldPassword"
                       value="<?= !empty($postData['oldPassword']) ? $postData['oldPassword'] : '' ?>"
                >
                <?php if (!empty($messages['oldPassword'])) { ?>
                    <span class="help is-danger"><?= $messages['oldPassword'] ?></span>
                <?php } ?>
            </p>

            <label class="label">New Password</label>
            <p class="control">
                <input class="input <?= !empty($messages['newPassword']) ? 'is-danger' : ''; ?>"
                       type="password"
                       name="newPassword"
                       value="<?= !empty($postData['newPassword']) ? $postData['newPassword'] : '' ?>"
                >
                <?php if (!empty($messages['newPassword'])) { ?>
                    <span class="help is-danger"><?= $messages['newPassword'] ?></span>
                <?php } ?>
            </p>

            <label class="label">Confirm New Password</label>
            <p class="control">
                <input class="input <?= !empty($messages['confirmNewPassword']) ? 'is-danger' : ''; ?>"
                       type="password"
                       name="confirmNewPassword"
                       value="<?= !empty($postData['confirmNewPassword']) ? $postData['confirmNewPassword'] : '' ?>"
                >
                <?php if (!empty($messages['confirmNewPassword'])) { ?>
                    <span class="help is-danger"><?= $messages['confirmNewPassword'] ?></span>
                <?php } ?>
            </p>

            <div class="control is-grouped">
                <p class="control">
                    <button class="button is-info">Submit</button>
                </p>
                <p class="control">
                    <button type="reset" onclick="usernameFocus()" class="button is-link">Cancel</button>
                </p>
            </div>
        </form>
    </div>
</section>
</body>
<script>
  function usernameFocus() {
    document.getElementById("username").focus();
  }
  usernameFocus();
</script>
</html>
