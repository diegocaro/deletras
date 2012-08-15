<?php
function myhtmlentities($t){ return htmlentities($t,ENT_QUOTES,"UTF-8"); }

function myurlencode($t){ return urlencode($t); }
/*
function mycode($t,$a=false) {
        //$t = strtolower($str);

        $art = array('los','las','el','la','un','una','unos','unas','the');

        if ($a==true) {
            foreach ($art as $a) {
                    if (eregi( '^('.$a.')([[:space:]]|-)' , $t )) {
                            $t = eregi_replace('^('.$a.')([[:space:]]|-)','',$t);
                            break;
                    }

            }
        }
        $s = "";
        $match = '[a-zA-Z0-9-]';
        for( $i=0; $i<strlen($t); $i++ ) {
                if( ereg( $match , $t[$i] ) )
                        $s .= $t[$i];
                else
                        $s .= '-'; //esto antes era un guion
        }
        
        $s=trim($s,"-");
        return $s;
}
*/
function mycode($string, $replacement = '-', $cutart = false) {

         $map = array(
             '/À|Á|Â/' => 'A',
             '/È|É|Ê|Ë/' => 'E',
             '/Ì|Í|Î/' => 'I',
             '/Ò|Ó|Ô/' => 'O',
             '/Ù|Ú|Û/' => 'U',
             '/Ñ/' => 'N',
             '/à|á|å|â/iu' => 'a',
             '/è|é|ê|ẽ|ë/iu' => 'e',
             '/ì|í|î/iu' => 'i',
             '/ò|ó|ô|ø/iu' => 'o',
             '/ù|ú|ů|û/iu' => 'u',
             '/ç/iu' => 'c',
             '/ñ/iu' => 'n',
             '/ä|æ/iu' => 'ae',
             '/ö/iu' => 'oe',
             '/ü/iu' => 'ue',
             '/Ä/iu' => 'Ae',
             '/Ü/iu' => 'Ue',
             '/Ö/iu' => 'Oe',
             '/ß/iu' => 'ss',
             '/[^\w\s]/iu' => ' ',
             '/\\s+/iu' => $replacement
         );
         $string = preg_replace(array_keys($map), array_values($map), $string);
         
         if ($cutart) {
            $art = "/^(los|las|el|la|un|una|unos|unas|the)$replacement/i";
            $string = preg_replace($art,'',$string);
         }
         
         $string = trim($string,$replacement);
         return $string;
     }

function normalize($s) {
    $s = html_entity_decode($s);
    $s = utf8_encode($s);
    $s = mycode($s);
    $s = strtolower($s);
    return $s;
}
     
     //echo mycode("ÁnéÍ");
?>
