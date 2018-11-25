<?php
class Main_model extends CI_Model
{
    public function __construct()
    {
        $this->load->library('session');
        $this->load->model('User_model');
        $this->load->library('user_agent');
        $this->load->database();
    }
    public function getShops()
    {
        $this->db->order_by('rate', 'DESC');
        $query = $this->db->get('shops')->result_array();
        return $query;
    }
    public function getShop($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('shops')->row_array();
        $query['rate'] = round($query['rate'], 1);
        $query['rate1'] = round($query['rate1'], 1);
        $query['rate2'] = round($query['rate2'], 1);
        $query['rate3'] = round($query['rate3'], 1);
        $query['canrate'] = $this->canRate($id);
        return $query;
    }
    public function getRates($sid)
    {
        $this->db->where('sid', $sid);
        $this->db->select('id, rate1, rate2, rate3, comment, time');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('rates')->result_array();
        return $query;
    }
    public function post($sid, $rate1, $rate2, $rate3, $comment)
    {
        $rate1 = (int)$rate1;
        $rate2 = (int)$rate2;
        $rate3 = (int)$rate3;

        if ($rate1 < 1 || $rate1 > 5 || $rate2 < 1 || $rate2 > 5 || $rate3 < 1 || $rate3 > 5) {
            $data = array(
                'status' => -1,
                'msg' => '分数错误'
            );
            return $data;
        }
        if (mb_strlen($comment, 'UTF-8') > 60) {
            $data = array(
                'status' => -1,
                'msg' => '评论内容太长'
            );
            return $data;
        }
        if (!$this->canRate($sid)) {
            $data = array(
                'status' => -1,
                'msg' => '您已发表过评价'
            );
            return $data;
        }

        $ip = $this->input->ip_address();
        $ua = $this->agent->agent_string();

        $comment = $this->security->xss_clean($comment);
        $ip = $this->security->xss_clean($ip);
        $ua = $this->security->xss_clean($ua);

        date_default_timezone_set("Asia/Shanghai");
        $data = array(
            'uid' => $this->session->user['uid'],
            'sid' => $sid,
            'rate1' => $rate1,
            'rate2' => $rate2,
            'rate3' => $rate3,
            'comment' => $comment,
            'name' => $this->session->user['name'],
            'grade' => $this->session->user['grade'],
            'class' => $this->session->user['class'],
            'number' => $this->session->user['number'],
            'ip' => $ip,
            'ua' => $ua,
            'time' => time()
        );

        if ($this->db->insert('rates', $data)) {
            $returndata = array(
                'status' => 1,
                'msg' => '评价成功！',
                'now' => $this->clacRank($sid)
            );
            return $returndata;
        } else {
            $returndata = array(
                'status' => -1,
                'msg' => '评价失败，请联系管理员处理！'
            );
            return $returndata;
        }
    }

    public function clacRank($sid)
    {
        $this->db->where('sid', $sid);
        $query = $this->db->get('rates')->result_array();
        $rate1=$rate2=$rate3=$rate=$num = 0;
        foreach ($query as $t) {
            $rate1 += $t['rate1'];
            $rate2 += $t['rate2'];
            $rate3 += $t['rate3'];
            $num++;
        }
        $rate1 = $rate1 / (double)$num;
        $rate2 = $rate2 / (double)$num;
        $rate3 = $rate3 / (double)$num;
        $rate = ($rate1*1 + $rate2*1 + $rate3*1) / (double)3;
        //echo $rate;
        $data = array(
            'rate' => $rate,
            'rate1' => $rate1,
            'rate2' => $rate2,
            'rate3' => $rate3
        );
        $this->db->where('id', $sid);
        
        $this->db->update('shops', $data);

        return $rate;
    }

    private function canRate($sid)
    {
        $this->db->where('uid', $this->session->user['uid']);
        $this->db->where('sid', $sid);
        return is_null($this->db->get('rates')->row());
    }
    
    private function splitName($fullname)
    {
        $hyphenated = array('欧阳','太史','端木','上官','司马','东方','独孤','南宫','万俟','闻人','夏侯','诸葛','尉迟','公羊','赫连','澹台','皇甫',
           '宗政','濮阳','公冶','太叔','申屠','公孙','慕容','仲孙','钟离','长孙','宇文','城池','司徒','鲜于','司空','汝嫣','闾丘','子车','亓官',
           '司寇','巫马','公西','颛孙','壤驷','公良','漆雕','乐正','宰父','谷梁','拓跋','夹谷','轩辕','令狐','段干','百里','呼延','东郭','南门',
           '羊舌','微生','公户','公玉','公仪','梁丘','公仲','公上','公门','公山','公坚','左丘','公伯','西门','公祖','第五','公乘','贯丘','公皙',
           '南荣','东里','东宫','仲长','子书','子桑','即墨','达奚','褚师');
        $vLength = mb_strlen($fullname, 'utf-8');
        $lastname = '';
        $firstname = '';//前为姓,后为名
        if ($vLength > 2) {
            $preTwoWords = mb_substr($fullname, 0, 2, 'utf-8');//取命名的前两个字,看是否在复姓库中
            if (in_array($preTwoWords, $hyphenated)) {
                $lastname = $preTwoWords;
                $firstname = mb_substr($fullname, 2, 10, 'utf-8');
            } else {
                $lastname = mb_substr($fullname, 0, 1, 'utf-8');
                $firstname = mb_substr($fullname, 1, 10, 'utf-8');
            }
        } elseif ($vLength == 2) {//全名只有两个字时,以前一个为姓,后一下为名
            $lastname = mb_substr($fullname, 0, 1, 'utf-8');
            $firstname = mb_substr($fullname, 1, 10, 'utf-8');
        } else {
            $lastname = $fullname;
        }
        return $lastname;
    }
}
