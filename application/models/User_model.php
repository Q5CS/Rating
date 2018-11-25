<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->library('session');
    }
    
    public function getUserToken($code) {
        $this->load->library('qz5z_oauth');
        $client_id = "rating";
        $client_secret = "******";
        $redirect_uri = "https://rating.qz5z.ren/main/auth_callback";
        $grant_type = "authorization_code";
        $scope = "";
        $t = $this->qz5z_oauth->getUserToken($code, $client_id, $client_secret, $redirect_uri, $grant_type, $scope);
        if(isset($t->error)) {
            return [-1,$t];
        }
        return [1,$t];
    }
    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    private function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }
        return $obj;
    }
    public function getUserData($token) {
        $this->load->library('qz5z_oauth');
        $t = $this->qz5z_oauth->getUserData($token, "");
        $t = $this->object_to_array($t);
        $this->session->logged = TRUE;
        $this->session->user = $t;
        $t['admin'] = FALSE;
        return array(
                'status' => 1,
                'name' => $t['name'],
                'msg' => '登录成功'
            );
        
    }
    public function logout() {
        $this->session->sess_destroy();
        $returndata = array(
            'status' => 1,
            'msg' => '注销成功'
        );
        return $returndata;
    }
    public function userinfo() {
        return $this->session->user;
    }
    public function logged() {
        return $this->session->logged;
    }
}
