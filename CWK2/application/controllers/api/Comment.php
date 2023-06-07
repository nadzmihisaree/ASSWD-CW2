<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

// login api
class Comment extends REST_Controller {
    
        function __construct()
        {
            // Construct the parent class
            parent::__construct();
            $this->load->model('CommentModel');  
        }

        public function index_post()
        {
            $comment = $this->post('commentDescription');
            $user_id = $this->post('userID');
            $post_id = $this->post('postID');
            $result = $this->CommentModel->addComment($comment, $user_id, $post_id);
            if ($result) {
                $this->response($result, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => TRUE,
                    'message' => 'No comment found'
                ], REST_Controller::HTTP_NO_CONTENT);
            }
        }


        public function index_get(){
            $id = $this->uri->segment(3);
            if ($id === NULL) {
                $result = $this->CommentModel->getComments();
                if ($result) {
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No comments found'
                    ], REST_Controller::HTTP_NO_CONTENT);
                }
            } else {
                $result = $this->CommentModel->getComment($id);
                if ($result) {
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No comment found'
                    ], REST_Controller::HTTP_NO_CONTENT);
                }
            }

        }
}