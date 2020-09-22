<?php 
  class csrf
  {
    public $ciphering = "AES-128-CTR"; 
    // public $iv_length = openssl_cipher_iv_length($this->ciphering);
    public $options = 0;
    public $encryption_iv = '1234567891011121';  
    public $encryption_key = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ1234567890";
    public $name = 'csrf_key';
    public $value;

    function creat_token()
    {
      $this->value = null;
      $_SESSION['hash'] = null;
      $REQUEST_TIME_FLOAT = $_SERVER['REQUEST_TIME_FLOAT'];
      $computername = gethostbyaddr($_SERVER['REMOTE_ADDR']).'/n'.$REQUEST_TIME_FLOAT;
      $token = $this->encrypt($computername);
      $_SESSION['hash'] = $token;
      $this->value = $token;
      return $this->value;
    }
    public function token_check()
    {
      $CI=&get_instance();
      if (array_key_exists('hash', $_SESSION)) {
        $token = $_SESSION['hash'];
      }

      if ($_SERVER['REQUEST_METHOD']=='POST') {
        if (array_key_exists($this->name, $_POST)) {
          if ($_POST[$this->name] == $_SESSION['hash']) {
            unset($_SESSION['hash']);
            unset($_POST[$this->name]);
            return true;
          }else{
            echo 'token tidak sesuai';
            header('HTTP/1.1 403 Forbidden');
            exit(403);
            // die;
          }
        }else {
          echo 'token tidak ditemukan';
          header('HTTP/1.1 403 Forbidden');
          exit(403);
          // die;
        }
      }
    }
    public function input_token()
    {
      return "<input type='hidden' name='$this->name' value='".$this->creat_token()."' />";
    }
    public function ajax_token($index=null)
    {
      $this->creat_token();
      switch ($index) {
        case 'name':
          $bind = $this->name;
          break;
        case 'token':
          $bind = $this->value;
          break;
        default:
          $bind = array(
            'name'  => $this->name,
            'token' => $this->value
          );
      }
      

      return $bind;
    }
    private function encrypt($string)
    {
      $encryption = openssl_encrypt(
        $string, 
        $this->ciphering,
        $this->encryption_key, 
        $this->options, 
        $this->encryption_iv
      ); 
      return $encryption;
    }
    private function decrypt($string)
    {
      $encryption = openssl_decrypt(
        $string, 
        $this->ciphering,
        $this->encryption_key, 
        $this->options, 
        $this->encryption_iv
      ); 
      return $encryption;
    }
  }

?>