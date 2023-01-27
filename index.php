<?php
header("content-Type: application/json");
require_once 'config.php';

$query = "SELECT DISTINCT pack_num, pack_qte FROM `p4_pack_operation`" ;
$rslt = $con->query($query) ;

$tab = [];
while ($item = $rslt->fetch_assoc()){
    $tab[] = $item;
}

$query2 = "SELECT DISTINCT pack_num, qte_fp, qte_df, qte FROM `p12_control` WHERE qte_df<>0" ;
$rslt2 = $con->query($query2) ;

$tab2 = [];
while ($item2 = $rslt2->fetch_assoc()) {
    $tab2[] = $item2;
    json_encode($tab);
    json_encode($tab2);
}

echo "\r\n Nombre des paaquets engagés = ", json_encode ($T = count($tab)), "\n"; //nombre des Paquets engagés

$i = 0;
$qengaged = 0;
while ($T >= $i) {
    $qengaged += $tab[$i]['pack_qte'];
    $i++;
}

$i = 0;
$qengaged = 0;
while (count($tab) >= $i) {
    $qengaged = $tab[$i]['pack_qte']+$qengaged;
    $i++;
}

$i1 = 0;
while (count($tab2) >= $i1) {
    $qfab = $tab2[$i1]['qte_fp']+ $qfab;
    $qdf = $tab2[$i1]['qte_df'] + $qdf;
    $i1++;
}

echo " La Quantité Engagée = ", json_encode ($qengaged);

echo "\r\n Nombre des paaquets encours = ",json_encode( count($tab) - count($tab2)), "\n"; //nombre des Paquets engagés

$qencours = $qengaged - $qfab;

echo "La Quantité encours = ", json_encode($qencours), "\n";

echo " La Quantité Fabriquée = ", json_encode($qfab), "\n";

$cq = ($qdf/ $qfab)*100 ;

echo " Indice de controle qualité = ",  json_encode(number_format($cq,2)), "%";
