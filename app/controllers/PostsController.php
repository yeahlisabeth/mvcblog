<?php

class PostsController extends Controller {

    public function __construct() {

        $this->postModel = $this->model('Post');
    }

    public function index() {

        $posts = $this->postModel->findAllPosts();
        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    public function create() {

        if(!isLoggedIn()) {
            header('location: ' . URLROOT . '/posts');
        }
        $data = [
            'title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'titleError' => '',
                'bodyError' => ''
            ];

            if (empty($data['title'])) {
                $data['titleError'] = 'theTitleOfAPostCannotBeEmpty';
            }
            if (empty($data['body'])) {
                $data['bodyError'] = 'theBodyOfAPostCannotBeEmpty';
            }
            if (empty($data['titleError']) && empty($data['bodyError'])) {
                if ($this->postModel->addPost($data)) {
                    header('location: ' . URLROOT . '/posts/index');
                } else {
                    die('somethingWentWrong');
                }
            } else {
                $this->view('posts/create', $data);
            }
        }

        $this->view('posts/create', $data);
    }

    public function update($id) {

        $post = $this->postModel->findPostById($id);

        if (!isLoggedIn()) {
            header('location: ' . URLROOT . '/posts');
        } elseif ($post->user_id != $_SESSION['user_id']) {
            header('location: ' . URLROOT . '/posts');
        }

        $data = [
            'post' => $post,
            'title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'post' => $post,
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'titleError' => '',
                'bodyError' => ''
            ];

            if (empty($data['title'])) {
                $data['titleError'] = 'theTitleOfAPostCannotBeEmpty';
            }
            if (empty($data['body'])) {
                $data['bodyError'] = 'theBodyOfAPostCannotBeEmpty';
            }

            if ($data['title'] == $this->postModel->findPostById($id)->title) {
                $data['titleError'] = 'atLeastChangeTheTitle';
            }

            if ($data['body'] == $this->postModel->findPostById($id)->body) {
                $data['bodyError'] = 'atLeastChangeTheBody';
            }

            if (empty($data['titleError']) && empty($data['bodyError'])) {
                if ($this->postModel->updatePost($data)) {
                    header('location: ' . URLROOT . '/posts');
                } else {
                    die('somethingWentWrong');
                }
            } else {
                $this->view('posts/update', $data);
            }
        }

        $this->view('posts/update', $data);
    }

    public function delete($id) {

        $post = $this->postModel->findPostById($id);

        if (!isLoggedIn()) {
            header('location: ' . URLROOT . '/posts');
        } elseif ($post->user_id != $_SESSION['user_id']) {
            header('location: ' . URLROOT . '/posts');
        }

        $data = [
            'post' => $post,
            'title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if ($this->postModel->deletePost($id)) {
                header('location: ' . URLROOT . '/posts');
            } else {
                die('somethingWentWrong');
            }
        }
    }
}