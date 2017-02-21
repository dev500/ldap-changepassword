<?php
use Slim\Http\Request;
use Slim\Http\Response;

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../models/Message.php');
$config = require(__DIR__ . '/../config/app.php');

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$container = new \Slim\Container($configuration);
$container['view'] = new \Slim\Views\PhpRenderer("../views/");

$app = new \Slim\App($container);

$messages = new Message;

/**
 * @param         $newPassword
 * @param         $confirmNewPassword
 * @param Message $messages
 *
 * @return bool
 */
function validatePassword($newPassword, $confirmNewPassword, $messages)
{
    if ($newPassword != $confirmNewPassword) {
        $messages->set([
            'newPassword' => 'Your new passwords do not match!',
            'confirmNewPassword' => 'Your new passwords do not match!'
        ]);
        return false;
    }
    if (strlen($newPassword) < 6) {
        $messages->set([
            'newPassword' => 'Your new password is too short. Your password must be at least 6 characters long.',
        ]);
        return false;
    }
    if (!preg_match("/[0-9]/", $newPassword)) {
        $messages->set([
            'newPassword' => 'Your new password must contain at least one number.',
        ]);
        return false;
    }
    if (!preg_match("/[a-zA-Z]/", $newPassword)) {
        $messages->set([
            'newPassword' => 'Your new password must contain at least one letter.',
        ]);
        return false;
    }
    return true;
}

$app->map(['GET', 'POST'], '/change-password', function (Request $request, Response $response) use ($config, $messages) {
    $postData = [];
    if ($request->isPost()) {
        $postData = $request->getParsedBody();
        $username = $postData['username'];
        $oldPassword = $postData['oldPassword'];
        $newPassword = $postData['newPassword'];
        $confirmNewPassword = $postData['confirmNewPassword'];

        $validate = validatePassword($newPassword, $confirmNewPassword, $messages);

        $connection = ldap_connect($config['ldapServer']);
        ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);

        if ($validate && $connection) {
            $userDn = $config['prefixUserDn'] . '=' . $username . ',' . $config['baseDn'];

            // Encode password
            $encodedNewPassword = "{SHA}" . base64_encode(pack("H*", sha1($newPassword)));
            $entry["userPassword"] = "$encodedNewPassword";
            if (@ldap_bind($connection, $userDn, $oldPassword) && ldap_modify($connection, $userDn, $entry)) {
                $messages->set([
                    'notification' => 'Change password success!',
                    'class' => 'is-success'
                ]);
                $postData = [];
            } else {
                $messages->set([
                    'notification' => 'Current username or password is wrong.',
                    'class' => 'is-danger'
                ]);
            }
        }
        ldap_close($connection);
    }
    $response = $this->view->render($response, 'index.php', ['messages' => $messages, 'postData' => $postData]);
    return $response;
});

$app->run();
