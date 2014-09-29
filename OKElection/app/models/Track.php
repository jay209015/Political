<?php
/**
 * User: jayrivers
 * Date: 8/11/14
 * Time: 9:32 PM
 */

class Track {

    private $summary_url = 'https://bcc.trackntrace.com/home/mailingssummary.aspx';
    private $login_url = 'https://bcc.trackntrace.com/login.aspx';
    private $username = 'griffingoodman';
    private $password = 'simchaw1';
    private $cookie = "";
    private $ch = false;
    private $jQuery = false;

    public function __construct(){
        $this->cookie = storage_path('cache').'/cookie.txt';
        $this->ch = curl_init();
        curl_setopt ($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt ($this->ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($this->ch, CURLOPT_COOKIEJAR, $this->cookie);


        $this->jQuery = new jQuery;
    }

    public function __destruct(){
        if($this->ch){
            $this->close();
        }
    }

    public function post($url, $data=array()){
        $postdata = http_build_query($data);
        curl_setopt ($this->ch, CURLOPT_URL, $url);
        curl_setopt ($this->ch, CURLOPT_REFERER, $url);
        curl_setopt ($this->ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt ($this->ch, CURLOPT_POST, 1);
        $result = curl_exec ($this->ch);

        return $result;
    }

    public function get($url){
        curl_setopt ($this->ch, CURLOPT_URL, $url);
        curl_setopt ($this->ch, CURLOPT_REFERER, $url);
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, "");
        $result = curl_exec ($this->ch);

        return $result;
    }

    public function getViewstate($url){
        $page_data = $this->get($url);
        $this->jQuery->load($page_data);

        $viewstate = $this->jQuery->find('#__VIEWSTATE')->one()->attr('value');
        $event_validation = $this->jQuery->find('#__EVENTVALIDATION')->one()->attr('value');

        return array($viewstate, $event_validation);
    }

    public function close(){
        curl_close($this->ch);
    }

    public function login(){

        list($viewstate, $event_validation) = $this->getViewstate($this->login_url);

        $data = array();
        $data['ctl00$Scriptmanager1'] = 'ctl00$ContentPlaceHolder1$UpdatePanel1|ctl00$ContentPlaceHolder1$Login1$LoginButton';
        $data['__LASTFOCUS'] = '';
        $data['__EVENTTARGET'] = '';
        $data['__EVENTARGUMENT'] = '';
        $data['__VIEWSTATE'] = $viewstate;
        $data['__EVENTVALIDATION'] = $event_validation;
        $data['ctl00$ContentPlaceHolder1$Login1$UserName'] = $this->username;
        $data['ctl00$ContentPlaceHolder1$Login1$Password'] = $this->password;
        $data['__ASYNCPOST'] = 'true';
        $data['ctl00$ContentPlaceHolder1$Login1$LoginButton'] = 'Log In';

        curl_setopt($this->ch, CURLOPT_COOKIESESSION, true);

        $this->post($this->login_url, $data);
    }

    public function getSummary(){
        $response = $this->get($this->summary_url);
        $this->jQuery->load($response);

        $summary_table = $this->jQuery->find('#ctl00_ContentPlaceHolder1_GridView1')->one()->html();
        $summary_table = str_replace('GridView', 'table', $summary_table);
        return $summary_table;
    }
}