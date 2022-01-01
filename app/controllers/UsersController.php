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
            //sanitize post data
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

            //validate username on letters/numbers
            if (empty($data['username'])) {
                $data['usernameError'] = 'pleaseEnterUsername';
            } elseif (!preg_match($nameValidation, $data['username'])) {
                $data['usernameError'] = 'nameCanOnlyContentLettersOrNumbers';
            }

            //validate email
            if (empty($data['email'])) {
                $data['emailError'] = 'pleaseEnterEmail';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = 'pleaseEnterTheCorrectFormat';
            } else {
                //check if email exists
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['emailError'] = 'emailIsAlreadyTaken';
                }
            }

            //validate password on length and numeric values
            if (empty($data['password'])) {
                $data['passwordError'] = 'pleaseEnterPassword';
            } elseif (strlen($data['password']) < 8) {
                $data['passwordError'] = 'passwordMustBeAtLeast8Characters';
            } elseif (!preg_match($passwordValidation, $data['password'])) {
                $data['passwordError'] = 'passwordMustHaveANumericValue';
            }

            //validate confirm password
            if (empty($data['confirmPassword'])) {
                $data['confirmPasswordError'] = 'pleaseEnterPassword';
            } else {
                if ($data['password'] != $data['confirmPassword'])  {
                    $data['confirmPasswordError'] = 'passwordsDoNotMatch';
                }
            }

            //make sure that errors are empty
            if (empty($data['usernameError']) && empty($data['emailError']) &&
                empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //register user from model function
                if ($this->userModel->register($data)) {
                    //redirect to the login page
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

        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => ''
            ];

            //validate username
            if (empty($data['username'])) {
                $data['usernameError'] = 'pleaseEnterAUsername';
            }
            //validate password
            if (empty($data['password'])) {
                $data['passwordError'] = 'pleaseEnterAPassword';
            }
            //check if all errors are empty
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
        header('location:' . URLROOT . '/pages/index');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        header('location:' . URLROOT . '/users/login');
    }
}