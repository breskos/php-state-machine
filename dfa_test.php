<?php

/**
 *@author Alexander Bresk <abresk@cip-labs.net>
 *@project Deterministic Finite Automaton in PHP
 *@file test.php
 *@description: test file  
 **/   

require 'DFA.class.php';


$dfa = new DFA('test_dfa');

$z0 = new DFA_State('z0');
$z0->setTransition('b', 'z0');
$z0->setTransition('c', 'z0');
$z0->setTransition('a', 'z1');
$dfa->setState($z0);

$z1 = new DFA_State('z1');
$z1->setTransition('b', 'z2');
$z1->setTransition('a', 'z1');
$z1->setTransition('c', 'z0');
$dfa->setState($z1);

$z2 = new DFA_State('z2');
$z2->setTransition('c', 'zE');
$z2->setTransition('b', 'z0');
$z2->setTransition('a', 'z1');
$dfa->setState($z2); 

$zE = new DFA_State('zE');
$zE->setTransition('c', 'zE');
$zE->setTransition('b', 'zE');
$zE->setTransition('a', 'zE');
$zE->setFinal(true);
$dfa->setState($zE);

$dfa->setStartingState('z0');


$result = $dfa->run('accbbababcababa', true);                   


if($result !== false){
  print_r($result);
}else{
  echo "This word isn't in that language!";
}

?>
