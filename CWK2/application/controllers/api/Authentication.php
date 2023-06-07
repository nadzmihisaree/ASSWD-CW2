<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

// login api
class Authentication extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('AuthenticationModel');
        $this->upload_path = './profileImages/'; 
    }

    // register user
    public function register_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $email = $this->post('email');
        $result = $this->AuthenticationModel->register($username, $password, $email);
        if ($result) {
            $this->response([
                'status' => TRUE,
                'message' => 'Login successful',
                'username' => $result->userName,
                'id' => $result->userID,
                'userDescription' => $result->userDescription,
                'profilePic' => $result->profilePic,

            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Username or email already exists'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function login_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $result = $this->AuthenticationModel->login($username, $password);
        if ($result) {
            // var_dump($result);
            // $jwt = new JWT();
            // $key = $this->config->item('jwt_key_HELOO_SECRET');
            // $iat = time();
            // $exp = $iat + 60;
            // $payload = array(
            //     "iss" => "Issuer",
            //     "aud" => "Audience",
            //     "iat" => $iat,
            //     "nbf" => $iat + 10,
            //     "exp" => $exp,
            //     "username" => $username);

            // $token = $jwt->encode($payload, $key, 'HS256');
            $this->response([
                'status' => TRUE,
                'message' => 'Login successful',
                'username' => $result->userName,
                'id' => $result->userID,
                'userDescription' => $result->userDescription,
                'profilePic' => $result->profilePic


            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid username or password'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function editprof_post()
    {
        $userid = $this->uri->segment(4);
        $username = $this->post('userName');
        $description = $this->post('userDesc');
        $profilePic = $this->post('profilePic');

        // var_dump($profilePic);

        $config['upload_path'] = './profileImages/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['maintain_ratio'] = TRUE;
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('profilePic')) {
            $result = $this->AuthenticationModel->editProfile($userid, $username, $description, NULL);
            if ($result) {
                $this->response($result, REST_Controller::HTTP_OK);
                $this->response([
                    'data' => $result,
                    'status' => TRUE,
                    'message' => 'Updated!1'
                ],
                REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Update failed!'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $getFileDet = array('upload_data' => $this->upload->data());
            $profilePic = $getFileDet['upload_data']['file_name'];
            $result = $this->AuthenticationModel->editProfile($userid, $username, $description, $profilePic);
            if ($result) {
                $this->response([
                    'data' => $result,
                    'status' => TRUE,
                    'message' => 'Updated!2'
                ],
                    REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Update failed!'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}