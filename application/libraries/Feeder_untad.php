<?php
class Feeder_untad {

  /**
    * configurasi feeder
    *
    * @var array
    */
  private $config = array(
    'host'     => 'http://103.245.72.97',
    'port'     => '8082',
    'username' => '001028p1',
    'password' => 'bauk2015'
  );
  
  private function runWS($data)
  {

    $url = $this->config['host'].':'.$this->config['port'].'/ws/live2.php';
    $ch = curl_init();
      
    curl_setopt($ch, CURLOPT_POST, 1);
    
    $headers = array();
    
    $headers[] = 'Content-Type: application/json';
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $data = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  private function token()
  {
   
    $res = $this->runWS(array(
     'act' => 'GetToken',
     'username' => $this->config['username'],
     'password' => $this->config['password']
    ));
    
    return json_decode($res)->data->token;
  }
  /**
   * fungsi get data from feeder
   *
   * @param string $act
   * @param string $filter
   * @param string $limit
   * @param string $offset
   * @return object
   */
  public function get($act,$filter='',$limit='',$offset='')
  {

    $params = array(
      'act'    =>$act,
      'token'  => $this->token(),
      'filter' => $filter,
      'limit'  => $limit,
      'offset' => $offset
    );

    return json_decode($this->runWS($params));
  }

  /**
   * fungsi insert feeder
   * 
   * @param string $act
   * @param array $record
   * @return object
   */
  public function insert($act,$record)
  {

    $params = array(
      'act'    => $act,
      'token'  => $this->token(),
      'record' => $record 
    );

    return json_decode($this->runWS($params));
  }

  /**
   * fungsi update data feeder
   *
   * @param string $act
   * @param string $key
   * @param array $record
   * @return object
   */
  public function update($act,$key,$record)
  {

    $params = array(
      'act'    => $act,
      'token'  => $this->token(),
      'key'    => $key,
      'record' => $record
    );

    return json_decode($this->runWS($params));
  }

  /**
   * fungsi delete data feeder
   *
   * @param string $act
   * @param string $key
   * @return object
   */
  public function delete($act,$key)
  {

    $params = array(
      'act'    => $act,
      'token'  => $this->token(),
      'key'    => $key
    );

    return json_decode($this->runWS($params));
  }

}
?>