<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrations_Controller extends MX_Controller {

  public function index($version){
    if(ENVIRONMENT !== 'development' || !$this->input->is_cli_request()){
      echo 'No tienes permisos para ejecutar este comando.';
      return;
    }
    $this->load->library('migration');
    if(!$this->migration->version($version))
      echo 'Error '.$this->migration->error_string();
    else
      echo '"Migrations" con versión '.$version.' se ejecutaron correctamente';
  }
}
