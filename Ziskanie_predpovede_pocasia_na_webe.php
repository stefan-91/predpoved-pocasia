<?php
error_reporting(E_ALL);
ini_set("display_errors","On"); 

class Ziskanie_predpovede_pocasia_na_webe {
    
public function zapisPredpoved() {
    $myJson = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?id=723674&lang=sk&units=metric&APPID=PRIVATNY_TOKEN'); // hodinova predpoved
    $myfile = fopen(dirname(__FILE__) . "/predpoved.txt", "w");    
    fwrite($myfile, $myJson);
}

//============== Vykreslenia ===============

public function vykresliPocasieGrafmi() {
    $pocasieInfo = $this->nacitajPredpoved();    
    $predoslyDatum = -1;
    $teplota = array();
    $pocitadlo = 0;
    foreach($pocasieInfo as $ntica) {
        if(strcmp($predoslyDatum, $ntica['datum']) != 0) {
            
            print_r($teplota);
            $pocitadlo = '';
            if(count($teplota) > 1) {
                $this->vykresliGraf($pocitadlo, 'Nazov grafu', $teplota);
                //break;
            }
            $pocitadlo++;
            
            // Posuvame datum
            $teplota = array();
            echo '<hr/>';
            $predoslyDatum = $ntica['datum'];
            
            echo "<strong> " . $ntica['datum'] . ' </strong><br/>';
        }

        $date = strtotime($ntica['hodina']);
        $hodina = intval(date('H', $date));
        
        $nTeplota['x'] = $hodina;
        $nTeplota['y'] = $ntica['teplota'];
        array_push($teplota, $nTeplota);
        /*
        //echo '<span>';
        echo "<strong>" . $ntica['hodina'] . '</strong><br/>';
        echo "" . $ntica['teplota'] . "&#8451;<br/>";
        echo $ntica['popis'] . ", ";
        
        echo "oblačnost ".$ntica['oblacnost']."%<br/>";
        echo "vietor s rýchlosťou ".$ntica['rychlost_vetra']." m/s";
        if($ntica['smer_vetra'] != null) echo " fúka ".$ntica['smer_vetra']."<br/>";
        else echo "<br/>";
        
        echo "vlhkosť ".$ntica['vlhkost']."%, ";
        if($ntica['zrazky'] != null) echo "zrážky ".$ntica['zrazky']." mm, ";
        echo "<br/>";
        echo "tlak ".$ntica['tlak']." hPa";
        echo "<br/><br/>";
        */
    }
}

public function vykresliPocasieGrid() {
    $pocasieInfo = $this->nacitajPredpoved();
    
    $predoslyDatum = -1;
    echo '<div class="row"> ';
    foreach($pocasieInfo as $ntica) {
        
        if(strcmp($predoslyDatum, $ntica['datum']) != 0) {            
            $predoslyDatum = $ntica['datum'];
            
            echo '<div class="column">';
            echo '<div class="pocasieDatum">';            
            echo '<span class="pocasieDatumText">';
            echo "<strong> " . $ntica['datum'] . ' </strong><br/>';
            echo '</span>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '<div class="column">';
        //echo '<div class="videoGrid">';
        
        // Obrazok
        echo '<div>';
        echo '<img src="'.$ntica['obrazok'].'" alt="' . $ntica['popis'] . '" >';
        echo '</div>';
        
        // Slovny popis
        echo '<div class="pocasieText">';
        echo "<strong>" . $ntica['hodina'] . '</strong><br/>';
        echo "" . $ntica['teplota'] . "&#8451;<br/>";
        echo $ntica['popis'] . ", ";        
        echo "<br>oblačnost ".$ntica['oblacnost']."%<br/>";
        echo "vietor ".$ntica['rychlost_vetra']." m/s";
        if($ntica['smer_vetra'] != null) echo "<br/>fúka ".$ntica['smer_vetra']."<br/>";
        else echo "<br/>";
        
        echo "vlhkosť ".$ntica['vlhkost']."%, ";
        if($ntica['zrazky'] != null) echo "zrážky ".$ntica['zrazky']." mm, ";
        echo "<br/>";
        echo "tlak ".$ntica['tlak']." hPa";
        echo '</div>';
        
        //echo '<div class="' . $stylVideo . '">' . ucfirst($nazov) . '</div>';
        
        //if($cas == true) {
            //$datum = $poleNavrhov[$i]['cas_publikovania'];
            //$datum = gmdate("d. m. Y", $datum);
            //echo ' ';
            //echo '<div class="videoDate">' . ucfirst($datum) . '</div>';
            
        //}

        //echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

public function vykresliPocasieSlovne() {
    $pocasieInfo = $this->nacitajPredpoved();
    
    $predoslyDatum = -1;
    foreach($pocasieInfo as $ntica) {
        if(strcmp($predoslyDatum, $ntica['datum']) != 0) {
            echo '<hr/>';
            $predoslyDatum = $ntica['datum'];
            
            echo "<strong>>> " . $ntica['datum'] . ' <<</strong><br/>';
        }
        
        //echo '<span>';
        echo "<strong>" . $ntica['hodina'] . '</strong><br/>';
        
        echo '<img src="'.$ntica['obrazok'].'" />';
        echo '<br/>';
        echo "" . $ntica['teplota'] . "&#8451;<br/>";
        echo $ntica['popis'] . ", ";
        
        echo "oblačnost ".$ntica['oblacnost']."%<br/>";
        echo "vietor s rýchlosťou ".$ntica['rychlost_vetra']." m/s";
        if($ntica['smer_vetra'] != null) echo " fúka ".$ntica['smer_vetra']."<br/>";
        else echo "<br/>";
        
        echo "vlhkosť ".$ntica['vlhkost']."%, ";
        if($ntica['zrazky'] != null) echo "zrážky ".$ntica['zrazky']." mm, ";
        echo "<br/>";
        echo "tlak ".$ntica['tlak']." hPa";
        echo "<br/><br/>";
    }
}


/*
public function vykresliPocasieGrafmi() {
    $pocasieInfo = $this->nacitajPredpoved();
    
    $predoslyDatum = -1;
    foreach($pocasieInfo as $ntica) {
        if(strcmp($predoslyDatum, $ntica['datum']) != 0) {
            echo '<hr/>';
            $predoslyDatum = $ntica['datum'];
            
            echo "<strong>>> " . $ntica['datum'] . ' <<</strong><br/>';
        }
        
        //echo '<span>';
        echo "<strong>" . $ntica['hodina'] . '</strong><br/>';
        echo "" . $ntica['teplota'] . "&#8451;<br/>";
        echo $ntica['popis'] . ", ";
        
        echo "oblačnost ".$ntica['oblacnost']."%<br/>";
        echo "vietor s rýchlosťou ".$ntica['rychlost_vetra']." m/s";
        if($ntica['smer_vetra'] != null) echo " fúka ".$ntica['smer_vetra']."<br/>";
        else echo "<br/>";
        
        echo "vlhkosť ".$ntica['vlhkost']."%, ";
        if($ntica['zrazky'] != null) echo "zrážky ".$ntica['zrazky']." mm, ";
        echo "<br/>";
        echo "tlak ".$ntica['tlak']." hPa";
        echo "<br/><br/>";
    }
}
*/

//============== Nacitanie z JSON ===========

private function nacitajPredpoved() {
    //$this->zapisPredpoved();
    
    //$myJson = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?id=723674&lang=sk&units=metric&APPID=083d31ca49218716f8e2ddd3359e31bb'); // hodinova predpoved
    $myJson = file_get_contents(dirname(__FILE__) . "/predpoved.txt");
    $predpovedPole = json_decode($myJson);    
    //echo '<pre>'; print_r($predpovedPole); echo '</pre>';
        
    $pocasieInfo = array();
    for($i=0; $i<count($predpovedPole->{'list'}); $i++) {
        $popis = $predpovedPole->{'list'}[$i]->{'weather'}[0]->{'description'};
                
        $tlak = $predpovedPole->{'list'}[$i]->{'main'}->{'pressure'}; // hPa
        $vlhkost = $predpovedPole->{'list'}[$i]->{'main'}->{'humidity'}; // %
        $oblacnost = $predpovedPole->{'list'}[$i]->{'clouds'}->{'all'};
        
        // Teplota
        $teplota = $predpovedPole->{'list'}[$i]->{'main'}->{'temp'};
        $teplota = round($teplota);
        
        // Vietor
        $rychlostVetra = $predpovedPole->{'list'}[$i]->{'wind'}->{'speed'}; //metrov za sekundu        
        $smerVetra = $predpovedPole->{'list'}[$i]->{'wind'}->{'deg'};
        $smerVetraSlovne = "";
        if($smerVetra > 330 && $smerVetra <= 30) $smerVetraSlovne = "zo severu";
        if($smerVetra > 30 && $smerVetra <= 60) $smerVetraSlovne = "zo severovýchodu";
        if($smerVetra > 60 && $smerVetra <= 120) $smerVetraSlovne = "z východu";
        if($smerVetra > 120 && $smerVetra <= 150) $smerVetraSlovne = "z juhovýchodu";
        if($smerVetra > 150 && $smerVetra <= 210) $smerVetraSlovne = "z juhu";
        if($smerVetra > 210 && $smerVetra <= 240) $smerVetraSlovne = "z juhozápadu";
        if($smerVetra > 240 && $smerVetra <= 300) $smerVetraSlovne = "zo západu";
        if($smerVetra > 300 && $smerVetra <= 330) $smerVetraSlovne = "zo severozápadu";
 
        //Zrazky
        $zrazky = "";
        if(isset($predpovedPole->{'list'}[$i]->{'rain'}->{'3h'})) $zrazky = $predpovedPole->{'list'}[$i]->{'rain'}->{'3h'}; //milimetrov
        if(isset($predpovedPole->{'list'}[$i]->{'snow'}->{'3h'})) $zrazky = $predpovedPole->{'list'}[$i]->{'snow'}->{'3h'}; //milimetrov
        
        //Cas a datum
        $cas = $predpovedPole->{'list'}[$i]->{'dt_txt'};
        $casUnix = strtotime($cas);
        //echo $casUnix . ' - cas <br/>';
        $datum = date('d.m.Y',$casUnix);
        $hodina = date('H:i',$casUnix);
        
        // Obrazok
        $urlObr = 'http://openweathermap.org/img/w/';
        $obrazok = $urlObr . $predpovedPole->{'list'}[$i]->{'weather'}[0]->{'icon'} . '.png';
        
        //---- Vypis ----
        $ntica = array();  
        // Incializacia
        $ntica['datum'] = null;
        $ntica['hodina'] = null;
        $ntica['teplota'] = null;
        $ntica['popis'] = null;
        $ntica['oblacnost'] = null;
        $ntica['rychlost_vetra'] = null;
        $ntica['smer_vetra'] = null;
        $ntica['vlhkost'] = null;
        $ntica['zrazky'] = null;
        $ntica['obrazok'] = null;
        // Naplnenie hodnotami        
        $ntica['datum'] = $datum;
        $ntica['hodina'] = $hodina;
        $ntica['teplota'] = $teplota;
        $ntica['popis'] = $popis;
        $ntica['oblacnost'] = $oblacnost;
        $ntica['rychlost_vetra'] = $rychlostVetra;
        if(strlen($smerVetraSlovne) > 0) $ntica['smer_vetra'] = $smerVetraSlovne;
        $ntica['vlhkost'] = $vlhkost;
        if(strlen($zrazky) > 0) $ntica['zrazky'] = $zrazky;
        $ntica['tlak'] = $tlak;
        $ntica['obrazok'] = $obrazok;
        
        array_push($pocasieInfo, $ntica);        
    }
    
    return $pocasieInfo;    
}

}
























































