<?php
// Define the capacities of the two Water Jug
$water_jug1 = 2;
$water_jug2 = 10;// Define the target volume of water
$target = 4;// Create a queue to store the states of the jugs
$queue = array(); // Create a visited array to keep track of the states we've already seen
$visited = array(); // Push the initial state onto the queue
array_push($queue, array(0, 0)); // Keep looping until the queue is empty
while (!empty($queue)) {
 // Pop the next state off the queue
 $state = array_shift($queue); // If the current state is the target, we're done!
 if ($state[0] == $target || $state[1] == $target) {
 echo "Found solution: (" . implode(", ", $state) . ")\n";
 break;
 } // If we haven't seen this state before, add it to the visited array
 if (!in_array($state, $visited)) {
 array_push($visited, $state); // Generate all possible next states by pouring water from one jug to another
 // Pour from jug 1 to jug 2
 $nextState = array($state[0], $state[0] + $state[1]);
 if ($nextState[0] > $water_jug1) {
 $nextState[0] = $water_jug1;
 $nextState[1] = $state[0] + $state[1] - $water_jug1;
 }
 if ($nextState[1] > $water_jug1) {
 $nextState[1] = $water_jug1;
 $nextState[0] = $state[0] - ($water_jug1 - $state[1]);
 }
 array_push($queue, $nextState); // Pour from jug 2 to jug 1
 $nextState = array($state[0] + $state[1], $state[1]);
 if ($nextState[0] > $water_jug1) {
 $nextState[0] = $water_jug1;
 $nextState[1] = $state[0] + $state[1] - $water_jug1;
 }
 if ($nextState[1] > $water_jug1) {
 $nextState[1] = $water_jug1;
 $nextState[0] = $state[0] - ($water_jug2 - $state[1]);
 }
 array_push($queue, $nextState); // Fill jug 1
 $nextState = array($water_jug1, $state[1]);
 array_push($queue, $nextState); // Fill jug 2
 $nextState = array($state[0], $water_jug2);
 array_push($queue, $nextState); // Empty jug 1
 $nextState = array(0, $state[1]);
 array_push($queue, $nextState); // Empty jug 2
 $nextState = array($state[0], 0);
 array_push($queue, $nextState);
 }
}
?>