<?php

class UsersController extends Controller {

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function register() {
        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            if (empty($data['username'])) {
                $data['usernameError'] = 'pleaseEnterUsername';
            } elseif (!preg_match($nameValidation, $data['username'])) {
                $data['usernameError'] = 'nameCanOnlyContentLettersOrNumbers';
            }

            if (empty($data['email'])) {
                $data['emailError'] = 'pleaseEnterEmail';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = 'pleaseEnterTheCorrectFormat';
            } else {

                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['emailError'] = 'emailIsAlreadyTaken';
                }
            }

            if (empty($data['password'])) {
                $data['passwordError'] = 'pleaseEnterPassword';
            } elseif (strlen($data['password']) < 8) {
                $data['passwordError'] = 'passwordMustBeAtLeast8Characters';
            } elseif (!preg_match($passwordValidation, $data['password'])) {
                $data['passwordError'] = 'passwordMustHaveANumericValue';
            }

            if (empty($data['confirmPassword'])) {
                $data['confirmPasswordError'] = 'pleaseEnterPassword';
            } else {
                if ($data['password'] != $data['confirmPassword'])  {
                    $data['confirmPasswordError'] = 'passwordsDoNotMatch';
                }
            }

            if (empty($data['usernameError']) && empty($data['emailError']) &&
                empty($data['passwordError']) && empty($data['confirmPasswordError'])) {

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    header('location: ' . URLROOT . '/users/login');
                } else {
                    die('somethingWentWrong');
                }
            }
        }

        $this->view('users/register', $data);
    }

    public function login() {

        $data = [
            'title' => 'Login page',
            'username' => '',
            'password' => '',
            'usernameError' => '',
            'passwordError' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => ''
            ];

            if (empty($data['username'])) {
                $data['usernameError'] = 'pleaseEnterAUsername';
            }

            if (empty($data['password'])) {
                $data['passwordError'] = 'pleaseEnterAPassword';
            }

            if (empty($data['usernameError']) && empty($data['passwordError'])) {
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'passwordOrUsernameIsIncorrect';

                    $this->view('users/login', $data);
                }
            }
        } else {

            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];
        }

        $this->view('users/login', $data);
    }

    public function createUserSession($user) {

        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        header('location:' . URLROOT . '/index');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        header('location:' . URLROOT . '/users/login');
    }
}