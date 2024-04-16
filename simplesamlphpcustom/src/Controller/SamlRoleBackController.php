<?php

namespace Drupal\simplesamlphpcustom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

/**
 * Returns responses for Customization routes.
 */
class SamlRoleBackController extends ControllerBase {

    /**
     * Builds the response.
     */
    public function content() {
    //   $connection = \Drupal::service('database');
    //   $connection->delete('simplesamlphp_kvstore')->execute();
      $database = \Drupal::database();
      $select_query = $database->select('simplesamlphp_kvstore');  // Hago una QUERY estática extendiendo desde DATABASE
      $results = $select_query->execute()->fetchAll();
      print_r($results);
      die();
      $build['content'] = [
        '#type' => 'item',
        '#markup' => '<h1>Destroys all of the data associated with the current weconnect session.</h1>',
      ];
  
      return $build;
    }
  
  }
  