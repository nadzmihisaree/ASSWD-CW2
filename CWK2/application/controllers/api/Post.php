<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;


class Post extends REST_Controller {
    
        function __construct()
        {
            // Construct the parent class
            parent::__construct();
            $this->load->model('PostModel');  
            $this->load->model('SearchModel');  
            $this->upload_path = './postImages/'; 
        }
    
        public function index_get()
        {
            $id = $this->uri->segment(3);
            if ($id === null) {
                $result = $this->PostModel->getPosts();
                if ($result) {
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No posts found'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                $result = $this->PostModel->getPost($id);
                if ($result) {
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No post found'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
        }
    
        public function index_post()
        {
            $caption = $this->post('caption');
            $user_id = $this->post('userID');
            $tags = $this->post('tags');

            // upload post as image
            $config['upload_path'] = './postImages/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 10240;
            $config['max_height'] = 7680;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->response($error, REST_Controller::HTTP_NOT_FOUND);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $post = $data['upload_data']['file_name'];
            }

            if ($post == null || $caption == null || $user_id == null) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Please fill all fields'
                ], REST_Controller::HTTP_NOT_FOUND);
            }else{
                $result = $this->PostModel->createPost($post, $caption, $user_id);
                // var_dump($result);
                if ($result) {
                    $data = array(
                        'tag' => $tags,
                        'post_id' => $result
                    );
                    $this->SearchModel->insertTags($tags, $result);
                } 
                $this->response([
                    'data' => $result,
                    'status' => TRUE,
                    'message' => 'Post created successfully'
                ],
                    REST_Controller::HTTP_CREATED);
            }
        }
            
        public function index_put()
        {
            $id = $this->uri->segment(3);
            $caption = $this->put('caption');
            $user_id = $this->put('userID');
            $tags = $this->put('tags');
            $result = $this->PostModel->updatePost($id, $caption, $user_id);
            if ($result) {
                $data = array(
                    'tag' => $tags,
                    'post_id' => $result
                );
                $this->SearchModel->insertTags($tags, $result);
            } 
            $this->response([
                'data' => $result,
                'status' => TRUE,
                'message' => 'Post updated successfully'
            ],
                REST_Controller::HTTP_CREATED);
        }
    
        public function index_delete()
        {
            $id = $this->uri->segment(3);
            $result = $this->PostModel->deletePost($id);
            if ($result) {
                $this->response($result, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to delete post'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
}

//  $id = $this->put('id');
// $title = $this->put('title');
// $content = $this->put('content');
// $result = $this->PostModel->updatePost($id, $title, $content);
// if ($result) {
//     $this->response($result, REST_Controller::HTTP_OK);
// } else {
//     $this->response([
//         'status' => FALSE,
//         'message' => 'Failed to update post'
//     ], REST_Controller::HTTP_NOT_FOUND);
// }