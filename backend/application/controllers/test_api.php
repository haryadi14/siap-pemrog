<?php
defined('BASEPATH') or exit('No direct script access allowed');

//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class test_api extends RestController
{
    function index_get()
    {
        return $this->response(
            array(
                'status' => true,
                'message' => 'Tes Response'
            )
        );
    }

    public function user_get()
    {
        //menampilkan response
        $this->response(array(
            'error' => false,
            'user' => array(
                'username' => 'Peter',
                'email' => 'peter@poltekpos.ac.id',
                'detail' => array(
                    'fullname' => 'Peter Holland',
                    'role' => 'Programmer',
                    'joined_data' => '2020-02-02'
                )
            )
        ));
    }
}
