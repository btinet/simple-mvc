<?php

namespace simplemvc\ Modules;

class Url {

   public static function redirect($url = null, $status) {
      header('Location: ' . DIR . $url, true, $status);
      exit;
   }

   public static function halt($status = 404, $message = 'Something went wrong.') {
      if (ob_get_level() !== 0) {
          ob_clean();
      }

      http_response_code($status);
      $data['status'] = $status;
      $data['message'] = $message;

      if (!file_exists("views/error/$status.php")) {
         $status = 'default';
      }
      require "views/error/$status.php";

      exit;
   }

   public static function HREF($filename = false) {
      if ($filename) {
         $path = "$filename";
      }
      return $path;
   }
	

	
	}
