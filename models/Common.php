<?php
/**
 * Created by PhpStorm.
 * User: zzf
 * Date: 2016/12/27
 * Time: 10:18
 */

namespace backend\models;


class Common
{
    public $ucApi = "http://192.168.3.159/ucenter";
    public $moveApi = "http://192.168.10.67:8083";
    public function chatgroups($groupname,$desc,$ownerm){
        $data["groupname"] = $groupname;
        $data["desc"] = $desc;
        $data["public"] = true;
        $data["maxusers"] = 2000;
        $data["approval"] = false;
        $data["owner"] = $ownerm;
        $data["groupicon"] = 1;
        $data["grouptype"] = 1;
        $data["iscompanygroup"] = 1;
        $apiUrl = $this->moveApi."/CommonData/v3/chatgroups";
        $json = $this->z_curl_post($apiUrl, $data);
        return $json;
    }
    //获取openId
    public function registerUcenterUser($mobile, $nickname = "", $password = "123456")
    {
        // 参数
        $params = array(
            'mobile' => $mobile,
            'password' => $password,
            'source' => 6,
            'nickname' => $nickname

        );
        $data = json_encode(array('data' => array("0" => $params)));

        // HTTP头   /*$accessToken压根可以不传  C#不校验APP管理员账户token*/
        $headers = array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data)
        );


        $apiUrl = $this->ucApi."/ucenter.php/user/admin/register";
        $json = $this->curl_post($apiUrl, $data, $headers);
        return $json;

    }

    /**
     * 调用周沛api所使用的方法
     * @param $url
     * @param $data
     * @param null $headers
     * @return mixed
     */
    function z_curl_post($url, $data, $headers = null){
        $postData = http_build_query($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HEADER, false);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    /**
     * 发送POST请求
     * @param String $url URL
     * @param Array $data | string  json串   发送的数据
     * @param Array $headers HTTP头
     */
    function curl_post($url, $data, $headers = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HEADER, false);

        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        return $data;
    }
    public function request_get($url = '') {
        if (empty($url)) {
            return false;
        }

        $ch = curl_init();//初始化curl
        //设置抓取的url
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        return $data;
    }
}