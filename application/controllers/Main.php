<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
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
        $this->load->model('Main_model');
        $this->load->helper('url');
    }

    public function index()
    {
        /* if (!$this->ion_auth->logged_in()) {
            redirect('/main/login');
        } */
        $data['add_css'] = array('fontawesome-all.min.css', 'fontawesome-stars.css');
        $data['add_js'] = array('jquery.barrating.min.js', 'main.js?v=3');
        $data['logged'] = $this->User_model->logged();
        $data['user'] = $this->User_model->userinfo();
        $data['shops'] = $this->Main_model->getShops();
        
        // $data['moneyRemain'] = $data['user']['balance'];

        $this->load->view('global/header', $data);
        $this->load->view('main/main', $data);
        $this->load->view('global/footer', $data);
    }
    
    public function auth_callback()
    {
        if ($this->User_model->logged()) {
            redirect('/');
        }
        $data['add_css'] = array();
        $data['add_js'] = array('auth_callback.js');
        $data['logged'] = $this->User_model->logged();
        $this->load->view('global/header', $data);
        $this->load->view('main/auth_callback', $data);
        $this->load->view('global/footer', $data);
    }
    
    public function login()
    {
        if ($this->User_model->logged()) {
            redirect('/');
        }
        // 使用认证平台登录
        redirect("https://open.qz5z.ren/oauth2/authorize?response_type=code&client_id=rating&redirect_uri=https://rating.qz5z.ren/main/auth_callback&state=auth&scope=");
        // $data['add_css'] = array();
        // $data['add_js'] = array('login.js');
        // $data['logged'] = $this->User_model->logged();
        // $this->load->view('global/header', $data);
        // $this->load->view('main/login');
        // $this->load->view('global/footer', $data);
    }

    public function shopinfo()
    {
        $id = $this->input->post('id');
        echo json_encode($this->Main_model->getShop($id));
    }

    public function rateinfo()
    {
        $id = $this->input->post('id');
        echo json_encode($this->Main_model->getRates($id));
    }

    public function post()
    {
        $sid = $this->input->post('sid');
        $rate1 = $this->input->post('rate1');
        $rate2 = $this->input->post('rate2');
        $rate3 = $this->input->post('rate3');
        $comment = $this->input->post('comment');
        echo json_encode($this->Main_model->post($sid, $rate1, $rate2, $rate3, $comment));
    }

    public function test()
    {
        echo $this->Main_model->clacRank(1);
    }
}
