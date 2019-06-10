<?php

namespace simplemvc\ Modules;

class Message {

   public static function show($message = false, $type = false) {
      $message = $message ? $message : Session::get('message');
      $type = $type ? $type : Session::get('message_type');
      $type = $type ? $type : 'success';

      if ($message) {
         require 'views/components/message.php';
         Session::clear('message');
         Session::clear('message_type');
      }
   }

   public static function set($message = false, $type = 'success') {
      Session::set('message', $message);
      Session::set('message_type', $type);
   }
}