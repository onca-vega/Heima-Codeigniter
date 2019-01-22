<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixtures_Controller extends MX_Controller {

  public function index(){
    if(ENVIRONMENT !== 'development' || !$this->input->is_cli_request()){
      echo 'No tienes permisos para ejecutar este comando.';
      return;
    }
    $this->_oauth2Client('oauth_clients');
    $this->_oauth2User('oauth_users');

    $ahora = date('Y-m-d H:i:s');
    $cliente = new Cliente('insert');
    $empresa = new Empresa('insert');
    $proyecto = new Proyecto('insert');
    $this->_cliente($cliente::TABLA, $ahora);
    $this->_empresa($empresa::TABLA, $ahora);
    $this->_proyecto($proyecto::TABLA, $ahora);
    echo '"Fixtures" se ejecutaron correctamente';
  }
  private function _oauth2Client($table){
    $this->db->truncate($table);
    $data = [
      [
        'client_id' => 'testclient',
        'client_secret' => 'testpass',
        'grant_types' => 'password',
        'redirect_uri' => 'http://localhost/',
        'scope' => 'Basic'
      ]
    ];
    $this->db->insert_batch($table, $data);
  }
  private function _oauth2User($table){
    $this->db->truncate($table);
    $data = [
      [
        'username' => 'onca-vega',
        'password' => password_hash('123asd', PASSWORD_DEFAULT),
        'first_name' => 'Marcos',
        'last_name' => 'Chávez',
        'email' => 'm-j.chavez.v@hotmail.com',
        'email_verified' => 1,
        'scope' => 'Basic'
      ]
    ];
    $this->db->insert_batch($table, $data);
  }

  private function _cliente($table, $now){
    $this->db->truncate($table);
    $data = [
      [
        'id' => 1,
        'usuario' => 'Onca',
        'nombre' => 'Marcos Jesús',
        'apellido_paterno' => 'Chávez',
        'apellido_materno' => 'Vega',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 2,
        'usuario' => 'Shibayram',
        'nombre' => 'Evelyn Noemí',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Somera',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 3,
        'usuario' => 'Perro_loco',
        'nombre' => 'Rodrigo',
        'apellido_paterno' => 'Meza',
        'apellido_materno' => 'Santos',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 4,
        'usuario' => 'Rupert',
        'nombre' => 'Ruperto',
        'apellido_paterno' => 'Hernández',
        'apellido_materno' => 'Vega',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 5,
        'usuario' => 'Roo',
        'nombre' => 'Roberto',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Palacios',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 6,
        'usuario' => 'Angie',
        'nombre' => 'Angélica',
        'apellido_paterno' => 'Pickles',
        'apellido_materno' => 'Santi',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 7,
        'usuario' => 'Kikin',
        'nombre' => 'Enrique',
        'apellido_paterno' => 'Chávez',
        'apellido_materno' => 'Alvarado',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 8,
        'usuario' => 'Chibis',
        'nombre' => 'Chibigon',
        'apellido_paterno' => 'Ratonero',
        'apellido_materno' => 'Barajas',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 9,
        'usuario' => 'Malvy',
        'nombre' => 'Malva',
        'apellido_paterno' => 'La Bola',
        'apellido_materno' => 'Gorda',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 10,
        'usuario' => 'Copito',
        'nombre' => 'Copo',
        'apellido_paterno' => 'La Ojitos',
        'apellido_materno' => 'Pispiretos',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 11,
        'usuario' => 'Salsa',
        'nombre' => 'Emma',
        'apellido_paterno' => 'Fernández',
        'apellido_materno' => 'Fernández',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 12,
        'usuario' => 'Bocha',
        'nombre' => 'Patash',
        'apellido_paterno' => 'Bocha',
        'apellido_materno' => 'Enojona',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 13,
        'usuario' => 'Audrilla',
        'nombre' => 'Audra',
        'apellido_paterno' => 'Apariencia',
        'apellido_materno' => 'Viejita',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 14,
        'usuario' => 'Galletin',
        'nombre' => 'Paque',
        'apellido_paterno' => 'De',
        'apellido_materno' => 'Galle',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 15,
        'usuario' => 'Yo-soy-Groot',
        'nombre' => 'Groot',
        'apellido_paterno' => 'Portero',
        'apellido_materno' => 'De Primera',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 16,
        'usuario' => 'Fofo',
        'nombre' => 'Adolfo',
        'apellido_paterno' => 'López',
        'apellido_materno' => 'Mateos',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 17,
        'usuario' => 'Sugar',
        'nombre' => 'Mike',
        'apellido_paterno' => 'Tyson',
        'apellido_materno' => '',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 18,
        'usuario' => 'Beno',
        'nombre' => 'Benito',
        'apellido_paterno' => 'Juárez',
        'apellido_materno' => 'Quezada',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 19,
        'usuario' => 'La_mary',
        'nombre' => 'Marisol',
        'apellido_paterno' => 'Samperio',
        'apellido_materno' => 'Torres',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 20,
        'usuario' => 'Ojitos',
        'nombre' => 'Iris',
        'apellido_paterno' => 'Villagran',
        'apellido_materno' => 'Alvarado',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 21,
        'usuario' => 'Lastin',
        'nombre' => 'Hugo',
        'apellido_paterno' => 'Sague',
        'apellido_materno' => 'Robledo',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ]
    ];
    $this->db->insert_batch($table, $data);
  }
  private function _empresa($table, $now){
    $data = [
      [
        'id' => 1,
        'nombre' => 'Procodific',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 2,
        'nombre' => 'Unosquare',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 3,
        'nombre' => 'Ksquare',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 4,
        'nombre' => 'Wizeline',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 5,
        'nombre' => 'Kueski',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 6,
        'nombre' => 'Ribown',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 7,
        'nombre' => 'Nike',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 8,
        'nombre' => 'Adiddas',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 9,
        'nombre' => 'Jordan',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 10,
        'nombre' => 'Playboy',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 11,
        'nombre' => '20 Century Fox',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 12,
        'nombre' => 'Totonalco',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 13,
        'nombre' => 'Enemon',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 14,
        'nombre' => 'Tech For Data',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 15,
        'nombre' => 'Advertising & Promotion',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 16,
        'nombre' => 'Banorte',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 17,
        'nombre' => 'Bancomer',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 18,
        'nombre' => 'Banamex',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 19,
        'nombre' => 'Vitae',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 20,
        'nombre' => 'Tecnocen',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 21,
        'nombre' => 'Grand Vision',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 22,
        'nombre' => 'Devlin',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 23,
        'nombre' => 'Ford',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 24,
        'nombre' => 'NASA',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 25,
        'nombre' => 'Nissan',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 26,
        'nombre' => 'Asus',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 27,
        'nombre' => 'LG',
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ]
    ];
    $this->db->insert_batch($table, $data);
  }
  private function _proyecto($table, $now){
    $data = [
      [
        'id' => 1,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Chocolates',
        'precio' => 25000,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 2,
        'id_cliente' => 1,
        'id_empresa' => 3,
        'nombre' => 'Mesas',
        'precio' => 7500,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 3,
        'id_cliente' => 1,
        'id_empresa' => 1,
        'nombre' => 'Sillas',
        'precio' => 3500,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 4,
        'id_cliente' => 2,
        'id_empresa' => 3,
        'nombre' => 'Videojuegos',
        'precio' => 75000,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 5,
        'id_cliente' => 1,
        'id_empresa' => 1,
        'nombre' => 'Chones',
        'precio' => 1370,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 6,
        'id_cliente' => 1,
        'id_empresa' => 1,
        'nombre' => 'Fundas de celular',
        'precio' => 2275,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 7,
        'id_cliente' => 12,
        'id_empresa' => 23,
        'nombre' => "M&M's",
        'precio' => 100,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 8,
        'id_cliente' => 1,
        'id_empresa' => 1,
        'nombre' => 'Zenphone 3',
        'precio' => 250,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 9,
        'id_cliente' => 7,
        'id_empresa' => 9,
        'nombre' => 'Macbook Pro',
        'precio' => 3570,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 10,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Tablet',
        'precio' => 55000,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 11,
        'id_cliente' => 7,
        'id_empresa' => 4,
        'nombre' => 'Android 3',
        'precio' => 1870,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 12,
        'id_cliente' => 4,
        'id_empresa' => 7,
        'nombre' => 'Android 5',
        'precio' => 6275,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 13,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Windows 98',
        'precio' => 95000,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 14,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Ubuntu 16.04',
        'precio' => 78500,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 15,
        'id_cliente' => 21,
        'id_empresa' => 11,
        'nombre' => 'Android 7.1',
        'precio' => 35800,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 16,
        'id_cliente' => 1,
        'id_empresa' => 3,
        'nombre' => 'Fedora',
        'precio' => 70800,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 17,
        'id_cliente' => 6,
        'id_empresa' => 1,
        'nombre' => 'Windows 7',
        'precio' => 5370,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 18,
        'id_cliente' => 1,
        'id_empresa' => 3,
        'nombre' => 'Debian',
        'precio' => 27275,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 19,
        'id_cliente' => 9,
        'id_empresa' => 1,
        'nombre' => 'RH app',
        'precio' => 25700,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 20,
        'id_cliente' => 1,
        'id_empresa' => 3,
        'nombre' => 'Devil May Cry 4',
        'precio' => 8500,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 21,
        'id_cliente' => 1,
        'id_empresa' => 3,
        'nombre' => 'Naruto',
        'precio' => 4500,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 22,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Dragon Ball Z',
        'precio' => 7800,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 23,
        'id_cliente' => 4,
        'id_empresa' => 1,
        'nombre' => 'Ridiculos',
        'precio' => 1970,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 24,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Badabun',
        'precio' => 2215,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 25,
        'id_cliente' => 1,
        'id_empresa' => 5,
        'nombre' => 'Facebook',
        'precio' => 25500,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 26,
        'id_cliente' => 1,
        'id_empresa' => 7,
        'nombre' => 'Twitter',
        'precio' => 7560,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 27,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Instagram',
        'precio' => 3540,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 28,
        'id_cliente' => 4,
        'id_empresa' => 3,
        'nombre' => 'Linkedin',
        'precio' => 78000,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 29,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Upwork',
        'precio' => 8370,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 30,
        'id_cliente' => 2,
        'id_empresa' => 20,
        'nombre' => 'MySQL',
        'precio' => 9275,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 31,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'MongoDB',
        'precio' => 345000,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 32,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'NodeJS',
        'precio' => 5800,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 33,
        'id_cliente' => 15,
        'id_empresa' => 1,
        'nombre' => 'Codeigniter',
        'precio' => 98700,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 34,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'VueJS',
        'precio' => 15500,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 35,
        'id_cliente' => 14,
        'id_empresa' => 4,
        'nombre' => 'Angular',
        'precio' => 1735,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 36,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Symfony',
        'precio' => 2277,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 37,
        'id_cliente' => 3,
        'id_empresa' => 5,
        'nombre' => 'Relojes inteligentes',
        'precio' => 25008,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 38,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'MP3 player',
        'precio' => 7509,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 39,
        'id_cliente' => 1,
        'id_empresa' => 10,
        'nombre' => 'Sombrillas',
        'precio' => 3502,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 40,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Bloqueadores de sol',
        'precio' => 75004,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 41,
        'id_cliente' => 2,
        'id_empresa' => 1,
        'nombre' => 'Estampado en playera',
        'precio' => 1373,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 42,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Estampado en tazas',
        'precio' => 2276,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 43,
        'id_cliente' => 5,
        'id_empresa' => 3,
        'nombre' => 'Estampado en ropa interior',
        'precio' => 25004,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 44,
        'id_cliente' => 2,
        'id_empresa' => 2,
        'nombre' => 'Muebles plegables',
        'precio' => 7507,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 45,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Trituradoras',
        'precio' => 3503,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 46,
        'id_cliente' => 1,
        'id_empresa' => 2,
        'nombre' => 'Fresadoras',
        'precio' => 75100,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 47,
        'id_cliente' => 7,
        'id_empresa' => 1,
        'nombre' => 'Tornos',
        'precio' => 1377,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ],
      [
        'id' => 48,
        'id_cliente' => 5,
        'id_empresa' => 2,
        'nombre' => 'Condones',
        'precio' => 2254,
        'tiempo_registro' => $now,
        'tiempo_edicion' => $now
      ]
    ];
    $this->db->insert_batch($table, $data);
  }
}
