<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_Controller extends Oauth2_Controller {
  public function info_get(){
    $this->response($this->version_010());
	}
  private function version_010(){
    return [
      "version" => "0.1.0",
      "resources" => [
        "cliente",
        "cliente/<id_cliente:\d+>/empresa",
        "cliente/<id_cliente:\d+>/empresa/<id_empresa:\d+>/proyecto",
        "empresa",
        "empresa/<id_empresa:\d+>/cliente",
        "empresa/<id_empresa:\d+>/cliente/<id_cliente:\d+>/proyecto"
      ]
    ];
  }
}
