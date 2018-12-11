<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Test_appstructure extends CI_Migration {

  public function up(){
    // OAUTH2
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ],
      'username' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'password' => [
        'type' => 'BLOB'
      ],
      'first_name' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'last_name' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'email' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'email_verified' => [
        'type' => 'BOOLEAN'
      ],
      'scope' => [
        'type' => 'VARCHAR',
        'constraint' => 4000
      ]
    ]);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('oauth_users', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'client_id' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'client_secret' => [
        'type' => 'BLOB'
      ],
      'redirect_uri' => [
        'type' => 'VARCHAR',
        'constraint' => 2000
      ],
      'grant_types' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'scope' => [
        'type' => 'VARCHAR',
        'constraint' => 4000
      ],
      'user_id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE
      ]
    ]);
    $this->dbforge->add_key('client_id', TRUE);
    $this->dbforge->create_table('oauth_clients', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'access_token' => [
        'type' => 'VARCHAR',
        'constraint' => 40
      ],
      'client_id' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'user_id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE
      ],
      'expires' => [
        'type' => 'TIMESTAMP'
      ],
      'scope' => [
        'type' => 'VARCHAR',
        'constraint' => 4000
      ]
    ]);
    $this->dbforge->add_key('access_token', TRUE);
    $this->dbforge->create_table('oauth_access_tokens', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'authorization_code' => [
        'type' => 'VARCHAR',
        'constraint' => 40
      ],
      'client_id' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'user_id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE
      ],
      'redirect_uri' => [
        'type' => 'VARCHAR',
        'constraint' => 2000
      ],
      'expires' => [
        'type' => 'TIMESTAMP'
      ],
      'scope' => [
        'type' => 'VARCHAR',
        'constraint' => 4000
      ],
      'id_token' => [
        'type' => 'VARCHAR',
        'constraint' => 1000
      ]
    ]);
    $this->dbforge->add_key('authorization_code', TRUE);
    $this->dbforge->create_table('oauth_authorization_codes', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'refresh_token' => [
        'type' => 'VARCHAR',
        'constraint' => 40
      ],
      'client_id' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'user_id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE
      ],
      'expires' => [
        'type' => 'TIMESTAMP'
      ],
      'scope' => [
        'type' => 'VARCHAR',
        'constraint' => 4000
      ]
    ]);
    $this->dbforge->add_key('refresh_token', TRUE);
    $this->dbforge->create_table('oauth_refresh_tokens', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'is_default' => [
        'type' => 'BOOLEAN'
      ],
      'scope' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ]
    ]);
    $this->dbforge->add_key('scope', TRUE);
    $this->dbforge->create_table('oauth_scopes', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'client_id' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'subject' => [
        'type' => 'VARCHAR',
        'constraint' => 80
      ],
      'public_key' => [
        'type' => 'VARCHAR',
        'constraint' => 2000
      ]
    ]);
    $this->dbforge->create_table('oauth_jwt', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    // App Tables
    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ],
      'usuario' => [
        'type' => 'BLOB'
      ],
      'nombre' => [
        'type' => 'VARCHAR',
        'constraint' => 128
      ],
      'apellido_paterno' => [
        'type' => 'VARCHAR',
        'constraint' => 64
      ],
      'apellido_materno' => [
        'type' => 'VARCHAR',
        'constraint' => 64
      ],
      'tiempo_registro' => [
        'type' => 'TIMESTAMP'
      ],
      'tiempo_edicion' => [
        'type' => 'TIMESTAMP'
      ]
    ]);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('cliente', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ],
      'nombre' => [
        'type' => 'VARCHAR',
        'unique' => true,
        'constraint' => 128
      ],
      'tiempo_registro' => [
        'type' => 'TIMESTAMP'
      ],
      'tiempo_edicion' => [
        'type' => 'TIMESTAMP'
      ]
    ]);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('empresa', FALSE, [ 'ENGINE' => 'InnoDB' ]);

    $this->dbforge->add_field([
      'id' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE,
        'auto_increment' => TRUE
      ],
      'id_cliente' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE
      ],
      'id_empresa' => [
        'type' => 'INT',
        'constraint' => 16,
        'unsigned' => TRUE
      ],
      'nombre' => [
        'type' => 'VARCHAR',
        'unique' => true,
        'constraint' => 128
      ],
      'precio' => [
        'type' => 'DOUBLE'
      ],
      'tiempo_registro' => [
        'type' => 'TIMESTAMP'
      ],
      'tiempo_edicion' => [
        'type' => 'TIMESTAMP'
      ]
    ]);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->add_field('CONSTRAINT proyecto_cliente_fk FOREIGN KEY (id_cliente) REFERENCES cliente(id)');
    $this->dbforge->add_field('CONSTRAINT proyecto_empresa_fk FOREIGN KEY (id_empresa) REFERENCES empresa(id)');
    $this->dbforge->create_table('proyecto', FALSE, [ 'ENGINE' => 'InnoDB' ]);
  }

  public function down(){
    $this->dbforge->add_field('ALTER TABLE proyecto DROP FOREIGN KEY proyecto_cliente_fk');
    $this->dbforge->add_field('ALTER TABLE proyecto DROP FOREIGN KEY proyecto_empresa_fk');
    $this->dbforge->drop_table('proyecto');
    $this->dbforge->drop_table('empresa');
    $this->dbforge->drop_table('cliente');

    $this->dbforge->drop_table('oauth_users');
    $this->dbforge->drop_table('oauth_clients');
    $this->dbforge->drop_table('oauth_access_tokens');
    $this->dbforge->drop_table('oauth_authorization_codes');
    $this->dbforge->drop_table('oauth_refresh_tokens');
    $this->dbforge->drop_table('oauth_scopes');
    $this->dbforge->drop_table('oauth_jwt');
  }
}
?>
