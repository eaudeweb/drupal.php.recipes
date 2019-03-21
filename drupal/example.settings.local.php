<?php

// @codingStandardsIgnoreFile

$databases['default']['default'] = array (
  'database' => 'dbname',
  'username' => 'root',
  'password' => 'root',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

$settings['trusted_host_patterns'] = [
  'project.local',
];

$settings['hash_salt'] = 'secret-hash-salt';

# Site mail
$config['system.site']['mail'] = 'user@example.ro';

# Configure Varnish purger to invalidate using front-end web server
$config['varnish_purger.settings.fe166b7d74']['hostname'] = 'www.example.com';
$config['varnish_purger.settings.fe166b7d74']['port'] = 443;
$config['varnish_purger.settings.fe166b7d74']['scheme'] = 'https';
$config['varnish_image_purge.configuration']['entity_types'] = ['random-entity-that-does-not-exist'];

# Recatpcha
$config['recaptcha.settings']['site_key'] = '';
$config['recaptcha.settings']['secret_key'] = '';

# Google Maps
$config['google_maps_api.install']['api_key'] = '';

# Google Analytics
$config['google_analytics.settings']['account'] = 'UA-0-0';

# SMTP
$config['smtp.settings']['smtp_host'] = 'secure.emailsrvr.com';
$config['smtp.settings']['smtp_port'] = 465;
$config['smtp.settings']['smtp_protocol'] = 'ssl';
$config['smtp.settings']['smtp_from'] = 'user@example.com';
$config['smtp.settings']['smtp_username'] = 'user@example.com';
$config['smtp.settings']['smtp_password'] = '';

# Raven
$config['raven.settings']['client_key'] = '';
$config['raven.settings']['public_dsn'] = '';
$config['raven.settings']['environment'] = '';
