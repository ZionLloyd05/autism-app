<?php
class Encryption {
    var $skey 	= "SuPerEncKey2010w"; // you can change i

    public  function encode($string){
		$data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function decode($string){
		 $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}
?>


