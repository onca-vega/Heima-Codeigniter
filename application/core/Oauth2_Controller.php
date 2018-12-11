<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

abstract class Oauth2_Controller extends REST_Controller {
  private $_storage;
  protected $_server;

  function __construct(){
    parent::__construct();
    // $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
    $this->_storage = new OAuth2\Storage\Pdo($this->_getPdo()); //, array( 'user_table' => 'usuario' ));
    // Pass a storage object or array of storage objects to the OAuth2 server class
    $this->_server = new OAuth2\Server($this->_storage, array(
      'allow_credentials_in_request_body' => false,
      'access_lifetime' => 3600*24
    ));
    $userStorage = new CustomUserStorage();
    $this->_server->addStorage($userStorage, 'user_credentials');

    // // Client Credentials
    // // Add the "Client Credentials" grant type (it is the simplest of the grant types)
    // $this->_server->addGrantType(new OAuth2\GrantType\ClientCredentials($this->_storage, array( 'allow_credentials_in_request_body' => false )));
    // Refresh Token
    // Add the "Refresh token" grant type
    $this->_server->addGrantType(new OAuth2\GrantType\RefreshToken($this->_storage));
    // User Credentials
    // Add the "User Credentials" grant type
    $this->_server->addGrantType(new OAuth2\GrantType\UserCredentials($userStorage));
    // // Add the "Authorization Code" grant type
    // $this->_server->addGrantType(new OAuth2\GrantType\AuthorizationCode($this->_storage));
  }

  private function _getPdo(){
    return array(
      'dsn' => 'mysql:dbname='.$this->db->database.';host='.$this->db->hostname,
      'username' => $this->db->username,
      'password' => $this->db->password
    );
  }

  protected function _authenticate(){
    if (!$this->_server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
        $this->_server->getResponse()->send();
        die;
    }
  }
}

class CustomUserStorage extends MX_Controller implements OAuth2\Storage\UserCredentialsInterface {
    function __construct(){
      parent::__construct();
    }

    public function checkUserCredentials($username, $password) {
      $result = $this->db->get_where('oauth_users', array( 'username' => $username ));
      $valid = $result->num_rows() === 1 && hash_equals($result->result()[0]->password, crypt($password, $result->result()[0]->password));
      return $valid ? array('user_id' => $result->result()[0]->id) : false;
    }

    public function getUserDetails($username) {
      $result = $this->db->get_where('oauth_users', array( 'username' => $username ));
      return $result->num_rows() === 1 ? array(
        'user_id' => $result->result()[0]->id,
        'scope' => 'Basic'
      ) : false;
    }
}
