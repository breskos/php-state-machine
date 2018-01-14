<?php
/**
 *@author Alexander Bresk <abresk@cip-labs.net>
 *@project Deterministic Finite Automaton in PHP
 *@file DFA.class.php
 **/   
require_once 'DFA_State.class.php';

class DFA{
  
  /**
   *@string - name of the dfa
   **/
   var $_name;
   
   /**
    *@array - array that contains the states of the DFA
    **/
   var $_states;
                  
   /**
    *@string - name of the starting state
    **/
   var $_starting_state;
   
   /**
    *@method __construct()
    *@param $name - name of the DFA
    *@return an DFA object
    **/               
   function __construct($name = ''){
    $this->_name = $name;
    $this->_states = array();
    $this->_starting_state = null;
   }       
   
   
   /**
    *@method setStartingState
    *@param $name - name of the starting state
    *@return void
    **/               
   function setStartingState($name){ $this->_starting_state = $name; }             
   
   /**
    *@method getStartingState
    *@return name of the starting state as string
    **/
   function getStartingState(){ return $this->_starting_state; }
   
   /**
    *@method setState
    *@param $state - name of the state (used as a key for the state array)
    *@return void
    **/
   function setState($state){$this->_states[$state->getName()] = $state;}
   
   /**
    *@method getState
    *@param $name - name of the state
    *@return DFA_State object
    **/
   function getState($name){
      if(isset($this->_states[$name])) return $this->_states[$name];
      else return false;
   }
   
   /**
    *@method stateExists
    *@param $name - name of the state (used as a key for the state array)
    *@return boolean (true -> exists || false -> !exists)
    **/
   function stateExists($name){
    if(isset($this->_states[$name])) return true;
    else return false;
   }
   
   /**
    *@method run
    *@param $word - word to check as string
    *@param $return_path - true -> return the path through the states & false -> return whether $word is a valid word
    *                              of the language that would be represented by the automaton
    *@return boolen ($return_path == false) | array ($return_path == true)
    **/                       
   function run($word, $return_path = true){
   //dfa is not well defined =(
   if(is_null($this->_starting_state) ||  !isset($this->_states[$this->_starting_state]) || count($this->_states) == 0)
      return false;
      
   $path = array();   
   $cur_state = $this->_states[$this->_starting_state];
   $word_len = strlen($word);
   
   for($i = 0; $i < $word_len; $i++){
    //set current state to path list
    $path[] = $cur_state->getName();
    if(($tmp = $cur_state->getTransition($word[$i])) === false)
      break;
    
    if(isset($this->_states[$tmp])) $cur_state = $this->_states[$tmp];
    else break;
   }   
   
   
   if($return_path) return $path;
   
   if(($i == $word_len) && $cur_state->isFinal()) return true;
   else return false;
  
  }
}
?>
