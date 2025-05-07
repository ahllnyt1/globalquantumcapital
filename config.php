<?php
// config.php

// Which PDO driver to use
define('DB_DRIVER', getenv('DB_DRIVER') ?: 'mysql');

// MySQL connection (defaults for local or fallback)
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'gqc');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Base URL (no trailing slash)
define(
  'BASE_URL',
  rtrim(
    getenv('BASE_URL') ?: 'http://localhost/globalquantumcapital',
    '/'
  )
);

// Timezone
date_default_timezone_set('UTC');
