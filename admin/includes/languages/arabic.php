<?php

 function lang($phrase) {

    static $lang = array(
      'message' => 'اهلا' ,
      'admin' => 'بالمدير'
    );
    return $lang[$phrase];
 }
