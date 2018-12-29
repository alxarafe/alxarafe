<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Database\Engines;

use Alxarafe\Database\SqlHelper;

/**
 * Personalization of SQL queries to use Firebird.
 */
class SqlFirebird extends SqlHelper
{
    /**
     *
     * Esta consulta funciona... Para tomarla como modelo.
     * Está pendiente de crear un AUTO_INCREMENT
     *
     * https://firebirdsql.org/refdocs/langrefupd15-create-table.html
     *

      CREATE TABLE people (
      id integer NOT NULL PRIMARY KEY,
      name varchar(50) NOT NULL,
      id_fiscal varchar(10) NOT NULL,
      age integer NOT NULL
      );
      CREATE INDEX person_name ON people(name);
      ALTER TABLE people ADD CONSTRAINT person_id_fiscal UNIQUE INDEX (id_fiscal);
      INSERT INTO people
      (id, name, id_fiscal, age)
     * VALUES
      ('1', 'Person 1', '11111111X', '21'),
      ('2', 'Person 2', '22222222Y', '32'),
      ('3', 'Person 3', '33333333Z', '43');

     */
    public function __construct()
    {
        parent::__construct();
    }
}
