# php-state-machine
PHP implementation of (Non) Deterministic Automaton.
Work on this project was done 2011.

## Deterministic Finite Automaton

An important area of the theoretical computer science deals with finite automata and languages. We use a finite automaton to detect words of regular languages. The types of grammars that create a language are defined in the CHOMSKY-hierachy (Noam Chomsky). The table below shows the CHOMSKY-hierachy:
```
0	- recursively enumerable
1	- context-sensitive
2	- context-free
3	- regular
```
To represent a regular grammar (type 3) you can use for instance a finite automaton. Here we are using a DFA (deterministic finite automaton) to display a regular grammar. A DFA consists of states and the automaton can reach a new state with an edge to another state (states are a kind of nodes or vertexes). Every state has a successor state for all tokens of the input alphabet. This input alphabet is specified:

for this example:
```
Σ = {a,b,c}
```
The DFA in the example below accepts all words that contain the sub string ‘abc':

```PHP
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

//to set zE as a final state
$zE->setFinal(true);
$dfa->setState($zE);

$dfa->setStartingState('z0');

$result = $dfa->run('accbbababcababa', true);
```

## Non Deterministic Automaton

To demonstrate an easy example, I use a NFA, that accepts a word, which includes the substring ‘abc’. I also used this example above (about DFAs). You can compare the following automaton with the DFA that accepts the same words and you would come to the conclusion, that the NFA is easier to build. Thats ist true, but on the other hand, in most (not all) cases the NFA needs more time to execute all simultanous calculations for a token from the alphabet.

An automaton needs (for formal description) an input alphabet. For that example, the alphabet is specified as:

for this example:
```php
Σ = {a,b,c}
```

A few sentences ago I mentioned, that the NFA needs more time to execute all simultanous calculations. But why? Well, let us choose the input word ‘ccababca’. (For further demonstrations I will use s1, s2, s3 and s4 as names for the states [blue circle] from the left to the right) We start the simulation with the first two tokens ‘cc’. The NFA remains in s1 (state 1). After that the NFA simulates for the token ‘a’. In s1 with input ‘a’ the NFA can go to s2 and can also stay in s1 (self-loop). Here we have the main problem! The NFA simulates all possible calculations and that is the problem, that the NFA has. After token ‘a’ comes token ‘b’ and for that token, the NFA simulates s1 and s3.

The PHP implementation of the NFA works with the transition table of every state. Outward from the starting state(s), the algorithm is looking for a transition from the current state to another – the successor state. After the input word was read, the NFA checks whether it is currently in a final state or not. The formalization of a final state is defined with a thicker border line (as you can see in the sketch above the text). In the PHP implementation it is just a boolean value. You can also choose more than one starting states with:

```php
$nfa = new NFA('test_nfa');
//adding new states
//declare starting states
$nfa->setStartingStates(array('s0','s1'));

```
The function, explained below, is very important to build NFA’s – but not neccessary. In the code example below, we don’t need this function, therefore it has an own example above.

The code example shows the code fragment, that has the equal functionality as the automaton in the sketch.

```PHP
require 'NFA.class.php';

$nfa = new NFA('test_nfa');

$s1 = new NFA_State('s1');
$s1->setTransition('b', 's1');
$s1->setTransition('c', 's1');
$s1->setTransition('a', 's2');
$s1->setTransition('a', 's1');
$nfa->setState($s1);

$s2 = new NFA_State('s2');
$s2->setTransition('b', 's3');
$nfa->setState($s2);

$s3 = new NFA_State('s3');
$s3->setTransition('c', 's4');
$nfa->setState($s3);

$s4 = new NFA_State('s4');
$s4->setTransition('c', 's4');
$s4->setTransition('b', 's4');
$s4->setTransition('a', 's4');
$s4->setFinal(true);
$nfa->setState($s4);

$nfa->setStartingState('s1');

if($nfa->run('accbbababcababa'))
  echo "NFA accepts the input word!";
else
  echo "NFA doesn't accept the input word!";
```

As you can see in this example, the NFA equals a pattern matcher. With a regular expression parser you are able to build small NFA’s for every part of this expressions. After that you can concatenate this automatons to an automaton, that accepts your complete expression.
