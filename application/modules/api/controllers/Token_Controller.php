<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_Controller extends Oauth2_Controller {
  public function token_post(){
    $this->_server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
	}
}
