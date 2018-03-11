<?php

class Auth
{
  /**
   * インスタンス生成
   */
  public function __construct()
  {
    require(__DIR__.'/setting.php');
    $this->callback_url  = $callback_url;
    $this->client_id     = $client_id;
    $this->client_secret = $client_secret;
  }

  /**
   * Get Access Token
   * 
   * @param string $auth_code
   * 
   * @return string $access_token
   */
  public function getAccessToken($auth_code)
  {
    $url = "https://api.line.me/oauth2/v2.1/token";
    $header = "Content-Type: application/x-www-form-urlencoded";
    $data = array(
      'grant_type' => 'authorization_code',
      'code' => $auth_code,
      'redirect_uri' => $this->callback_url,
      'client_id' => $this->client_id,
      'client_secret' => $this->client_secret
    );
    $content = http_build_query($data);
    $options = array('http' => array(
      'method' => 'POST',
      'header' => $header,
      'content' => $content
    ));
    $contents = file_get_contents($url, false, stream_context_create($options));
    $access_token = json_decode($contents, true)['access_token'];
    return $access_token;
  }

  /**
   * Check Access Token
   * 
   * @param string $access_token
   */
  public function checkAccessToken($access_token)
  {
    $url = "https://api.line.me/oauth2/v2.1/verify?access_token=$access_token";
    $result = file_get_contents($url);
    return $result;
  }

  /**
   * Revoke Access Token
   * 
   * @param string $access_token
   */
  public function revokeAccessToken($access_token)
  {
    $url = 'https://api.line.me/oauth2/v2.1/revoke';
    $header = 'Content-Type: application/x-www-form-urlencoded';
    $data = array(
      'access_token'  => $access_token,
      'client_id'     => $this->client_id,
      'client_secret' => $this->client_secret
    );
    $content = http_build_query($data);
    $options = array(
      'http' => array(
        'method'  => 'POST',
        'header'  => $header,
        'content' => $content
      )
    );
    $contents = file_get_contents($url, false, stream_context_create($options));
  }

  /**
   * Get Profile
   * 
   * @param string $access_token
   */
  public function getProfile($access_token)
  {
    $url = 'https://api.line.me/v2/profile';
    $header = "Authorization: Bearer $access_token";
    $options = array(
      'http' => array(
        'method' => 'POST',
        'header' => $header
      )
    );
    $contents = file_get_contents($url, false, stream_context_create($options));
    $profile = json_decode($contents, true);
    return $profile;
  }

}