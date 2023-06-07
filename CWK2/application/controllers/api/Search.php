<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

// login api
class Search extends REST_Controller {
    
        function __construct()
        {
            // Construct the parent class
            parent::__construct();
            $this->load->model('PostModel');  
        }
    
        public function index_get(){
            $tag = $this->uri->segment(3);
            if ($tag === NULL) {
                $result = $this->PostModel->getPosts();
            } else {
                $result = $this->PostModel->getSearch($tag);
            }
                if ($result) {
                    $this->response($result, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No searches found'
                    ], REST_Controller::HTTP_NO_CONTENT);
                }
            }
        

    
}