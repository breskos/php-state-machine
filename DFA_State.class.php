<?php

/**
 *@author Alexander Bresk <abresk@cip-labs.net>
 *@project Deterministic Finite Automaton in PHP
 *@file DFA_State.class.php
 **/   


class DFA_State{

  
  /**
   *@string - name of the state
   **/      
   var $_name;
        
  /**
   *@array - contains the transitions to other states
   **/    
  var $_transition_table;
  
  /**
   *@bool - is a final state or not
   **/
   var $_is_final;     
   
   
   /**
    *@method __construct
    *@param $name - name of the state
    *@return an DFA_State object
    **/         
   function __construct($name){
    $this->_name = $name;
    $this->_transition_table = array();
    $this->_is_final = false;
   }
   
   /**
    *@method setName
    *@param $name - name of the state
    *@return void
    **/         
   function setName($name){ return $this->_name = $name; }
   
   /**
    *@method getName
    *@return name as a string
    **/         
   function getName(){ return $this->_name; }
   
   /**
    *@method isFinal
    *@return boolean
    **/         
   function isFinal(){ return $this->_is_final; }
   
   /**
    *@method setFinal
    *@param $final - boolean, set this state final
    *@return void
    **/         
   function setFinal($final){ $this->_is_final = $final; }
   
   /**
    *@method setTransitionTable
    *@param $array - the complete transition table as array
    *@return void
    **/         
   function setTransitionTable($array){ $this->_transition_table = $array; }
   
   /**
    *@method getTransitionTable
    *@return transition table as an array
    **/         
   function getTransitionTable(){ return $this->_transition_table; }
   
   /**
    *@method setTransition
    *@param $symbol - symbol
    *@param $state - successor sate    
    *@return void
    **/         
   function setTransition($symbol, $state){ $this->_transition_table[$symbol] = $state; }
   
   /**
    *@method getTransition
    *@param $symbol - get the transition for this symbol
    *@return name of the state or false
    **/         
   function getTransition($symbol){
      return (isset($this->_transition_table[$symbol]))? $this->_transition_table[$symbol] : false;
  }

}



?>
