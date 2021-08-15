<?php 

//-----------Codigo de luhn para validar las cc generadas si son validas con el algoritmo
function luhn($number) {
$odd = true;
$sum = 0;

foreach ( array_reverse(str_split($number)) as $num) {
$sum += array_sum( str_split(($odd = !$odd) ? $num*2 : $num) );
}

return (($sum % 10 == 0) && ($sum != 0));
}



// --------  Extrapolacion para generar con orden 
function extr_cc($cc,$mes,$año,$cvv,$cnt_extr) {

$validas_cc=0;
$todas_cc_validas=array();
$cnt_x=0;
$cnt_cc=strlen($cc);
$contador=0;

//para saver cuantas x tiene la cc
for ($i=0; $i < $cnt_cc ; $i++) { 
if ($cc[$i]=='x'||$cc[$i]=='X') {
 $cnt_x++;}}

$cc_terminada='';
 $nueve=str_pad("9", $cnt_x, "9", STR_PAD_LEFT);  // $nueve = 99

for ($k=0; $k <= $nueve; $k++) {    //  # 1
$random=str_pad($k, $cnt_x, "0", STR_PAD_LEFT);      //$random=00

$numero_de_string_de_random=strlen($random);  //numero_de_String_de_random='2';

	

for ($m=0; $m < $cnt_cc ; $m++) {   //   # 3

if ($cc[$m]=='x'||$cc[$m]=='X') {

 $cc_terminada.=$random[$contador];
$contador++;
 }else{
 $cc_terminada.=$cc[$m];
 }

} //   # 3

if(luhn($cc_terminada)==1){
	$validas_cc++;
$todas_cc_validas[$validas_cc]=$cc_terminada."|".$mes."|".$año."|".$cvv; //-------------------->> las metes a un array para luego consultarlas

if (count($todas_cc_validas)==$cnt_extr) {
$contador_de_array=count($todas_cc_validas);

for ($i=1; $i <= $contador_de_array; $i++) { 
echo "<br>".$todas_cc_validas[$i];
}
	die("<br> \x20 \x1F \x1F \x1FYa se termino la Extrapolacion, exactamente son : ".$contador_de_array);
	break;

}

//echo "<br>".$cc_terminada."|".$mes."|".$año."|".$cvv;
}

$cc_terminada='';
$contador=0;

}   //  # 1

}






//----------------- Extrapolacion en random
function extr_random($cc,$mes,$año,$cvv,$cnt_extr){
$cc_terminada="";
$cnt_cc=strlen($cc); //cuenta la cantidad de caracteres que tiene la cc
$array_de_cc=array();
$contador_de_array=0; //cuenta la cc que tiene este array
do {
for ($i=0; $i < $cnt_cc ; $i++) {  // for # 2
if ($cc[$i]=='x'||$cc[$i]=='X') {
 $cc_terminada.=rand(0,9);
 }else{
 $cc_terminada.=$cc[$i];
 }
}  // for # 2
if(luhn($cc_terminada)==1){
$array_de_cc[$contador_de_array]=$cc_terminada."|".$mes."|".$año."|".$cvv;
$array_de_cc=array_unique($array_de_cc);  //quita las cc duplicadas -------------------> solo permite 620
//subir la cantidad de memoria 
$contador_de_array=count($array_de_cc);
}
$cc_terminada="";
}while ($contador_de_array < $cnt_extr);

for ($i=0; $i < $contador_de_array; $i++) { 
echo "<br>".$array_de_cc[$i];
}
//print_r($array_de_cc);
}








// extr_random('53605811111xxxxx','01','2021','123','1000');
extr_cc('53605811111xxxxx','01','2021','123','1000');





 ?>