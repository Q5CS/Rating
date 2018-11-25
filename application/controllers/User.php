<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }
    public function auth()
    {
        $code = $this->input->post("code");
        $t = $this->User_model->getUserToken($code);
        if ($t[0] < 0) {
            echo json_encode(['status' => -1, 'msg' => $t[1]]);
            return;
        }
        $token = $t[1]->access_token;
        //然后拿着token要用户数据
        $t = $this->User_model->getUserData($token);
        echo json_encode($t);
    }
    public function logout()
    {
        echo json_encode($this->User_model->logout());
    }

    public function info()
    {
        echo json_encode($this->User_model->userinfo());
    }
}
