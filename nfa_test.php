<?php

/**
 *@author Alexander Bresk <abresk@cip-labs.net>
 *@project Deterministic Finite Automaton in PHP
 *@file test.php
 *@description: test file  
 **/   

require 'NFA.class.php';


$nfa = new NFA('test_nfa');

$z0 = new NFA_State('z0');
$z0->setTransition('b', 'z0');
$z0->setTransition('c', 'z0');
$z0->setTransition('a', 'z1');
$z0->setTransition('a', 'z0');
$nfa->setState($z0);

$z1 = new NFA_State('z1');
$z1->setTransition('b', 'z2');
$nfa->setState($z1);

$z2 = new NFA_State('z2');
$z2->setTransition('c', 'zE');
$nfa->setState($z2); 

$zE = new NFA_State('zE');
$zE->setTransition('c', 'zE');
$zE->setTransition('b', 'zE');
$zE->setTransition('a', 'zE');
$zE->setFinal(true);
$nfa->setState($zE);

//$nfa->setStartingStates(array('z0','z1'));
$nfa->setStartingState('z0');


if($nfa->run('accbbababcababa'))
  echo "NFA accepts the input word!";
else
  echo "NFA doesn't accept the input word!";
  
?>
