<?php
function _fill($state, $water_jug, $type = 1)
{
	if ($type) {
		return array($water_jug, $state[$type]);
	}
	return array($state[$type], $water_jug);
}

function _empty($state, $type = 1)
{
	if ($type) {
		return array(0, $state[$type]);
	}
	return array($state[$type], 0);
}

function _transfer($state, $water_jug1, $water_jug2, $type = 1)
{
	if ($type == 1) {
		$nextState = array($state[0], $state[0] + $state[1]);
		if ($nextState[0] > $water_jug1) {
			$nextState[0] = $water_jug1;
			$nextState[1] = $state[0] + $state[1] - $water_jug1;
		}
		if ($nextState[1] > $water_jug1) {
			$nextState[1] = $water_jug1;
			$nextState[0] = $state[0] - ($water_jug1 - $state[1]);
		}
		return $nextState;
	}

	$nextState = array($state[0] + $state[1], $state[1]);
	if ($nextState[0] > $water_jug1) {
		$nextState[0] = $water_jug1;
		$nextState[1] = $state[0] + $state[1] - $water_jug1;
	}
	if ($nextState[1] > $water_jug1) {
		$nextState[1] = $water_jug1;
		$nextState[0] = $state[0] - ($water_jug2 - $state[1]);
	}

	return $nextState;
}

function process($water_jug1, $water_jug2, $target)
{
	$queue = array(); // Create a visited array to keep track of the states we've already seen
	$visited = array(); // Push the initial state onto the queue
	array_push($queue, array(0, 0)); // Keep looping until the queue is empty
	$result = 'No Solution';
	while (!empty($queue)) {
		// Pop the next state off the queue
		$state = array_shift($queue); // If the current state is the target, we're done!
		if ($state[0] == $target || $state[1] == $target) {
			$result = "Found solution: (" . implode(", ", $state) . ")\n";
			break;
		} // If we haven't seen this state before, add it to the visited array
		if (!in_array($state, $visited)) {
			array_push($visited, $state); // Generate all possible next states by pouring water from one jug to another

			array_push($queue, _transfer($state, $water_jug1, $water_jug2)); // Pour from jug 2 to jug 1
			array_push($queue, _transfer($state, $water_jug1, $water_jug2, 2)); // Pour from jug 1 to jug 2

			array_push($queue, _fill($state, $water_jug1)); // Fill jug 1
			array_push($queue, _fill($state, $water_jug2, 0)); // Fill jug 2
			
			array_push($queue, _empty($state)); // Empty jug 1
			array_push($queue, _empty($state, 0)); // Empty jug 2
		}
	}
	return $result;
}

// Define the capacities of the two Water Jug
// Define the target volume of water
// Create a queue to store the states of the jugs
echo process(2, 10, 4);
