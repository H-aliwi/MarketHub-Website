<?php  
function  lang($phrase)

{
// Create array name '$tmpl'
//  'key' => 'value'
    static $lang = array(


        'Welcome' =>'مرحبا'
    
    
    );



       return $lang[$phrase];



}

?>