<?php
/**
 *@author Alexander Bresk <abresk@cip-labs.net>
 *@project Non Deterministic Finite Automaton in PHP
 *@file NFA.class.php
 **/   
require_once 'NFA_State.class.php';

class NFA{
  
  /**
   *@string - name of the nfa
   **/
   var $_name;
   
   /**
    *@array - array that contains the states of the NFA
    **/
   var $_states;
                  
   /**
    *@string - name of the starting state
    **/
   var $_starting_state;
   
   /**
    *@array - threads of the nfa
   **/
   var $_threads;       
   
   /**
    *@method __construct()
    *@param $name - name of the NFA
    *@return an DFA object
    **/               
   function __construct($name = ''){
    $this->_name = $name;
    $this->_states = array();
    $this->_starting_states = array();
    $this->_threads = array();
   }       
   
   
   /**
    *@method setStartingStates
    *@param $name - name of the starting state
    *@return void
    **/               
   function setStartingStates($array){ $this->_starting_state = $array; }             
   
   
   /**
    *@method setStartingState
    *@param $name - name of the starting state
    *@return void
    **/               
   function setStartingState($name){ $this->_starting_state = array($name); }             
   
   
   /**
    *@method getStartingState
    *@return name of the starting state as string
    **/
   function getStartingState(){ return $this->_starting_state[0]; }
   
   
   /**
    *@method getStartingStates
    *@return array of the starting states
    **/
   function getStartingStates(){ return $this->_starting_state; }
   
   
   /**
    *@method setState
    *@param $state - name of the state (used as a key for the state array)
    *@return void
    **/
   function setState($state){$this->_states[$state->getName()] = $state;}
   
   /**
    *@method getState
    *@param $name - name of the state
    *@return NFA_State object
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
    *
    *@return boolean
    **/                       
   function run($word, $return_path = true){
   //nfa is not well defined =(
   if(is_null($this->_starting_state) || count($this->_states) == 0)
      return false;
      
   //assign states
   $this->_threads = array();
   foreach($this->_starting_state as $v) $this->_threads[] = $this->_states[$v];
      
   $word_len = strlen($word);
   
   for($i = 0; $i < $word_len; $i++){
    //set current state to path list
    if(sizeof($this->_threads) == 0) break;
    $this->simulateThreads($word[$i]);
   }   
   
   if(($i == $word_len) && $this->inFinalState()) return true;
   else return false;
  
  }
  
  /**
    *@method simulateThreads
    *@param $symbol - symbol to simulate
    *@return void
    **/
  function simulateThreads($symbol){
    $new_states = array();
      foreach($this->_threads as $thread){
        if(($transitions = $thread->getTransitions($symbol)) !== false){
          foreach($transitions as $transition)
            if(!in_array($transition, $new_states))
              $new_states[] = $transition;
        } 
      }
    $this->_threads = array();  
    foreach($new_states as $state)
      $this->_threads[] = $this->_states[$state];
  }
  
  /**
    *@method run
    *@param no params
    *@return boolen one thread is final state -> true  | else -> false
    **/
  function inFinalState(){
    foreach($this->_threads as $thread) if($thread->isFinal()) return true;
    return false;
  }
}
?>
