<?php
require_once "Player.php";
function playDiceGame($numPlayers, $numDice): void
{
    // initialize players
    $players = [];
    $outPlayers = [];
    for ($i = 0; $i < $numPlayers; $i++) {
        $players[] = new Player("Player " . ($i + 1), $numDice);
    }

    echo("Welcome to the dice game!\n");
    echo("Number of players: " . $numPlayers  . "\n");
    echo("Number of dice per player: " . $numDice . "\n");

    $activePlayer = count($players);

    while ($activePlayer > 1) {
        // roll
        for ($i = 0; $i < count($players); $i++) {
                $players[$i]->roll();
        }

        //calculate score and remain dice
        for ($i = 0; $i < count($players); $i++) {
            $_score = $players[$i]->getLastScore();
            for ($j = 0; $j < count($_score); $j++) {
                if ($_score[$j] === 6) {
                    $players[$i]->addPoint();
                } else if ($_score[$j] === 1) {
                    $players[$i]->removeDice();

                    $_nextPlayerIndex = $i === (count($players) - 1) ? 0 : $i + 1;
                    $players[$_nextPlayerIndex]->addDice();
                }
            }
        }

        // evaluation
        for ($i = 0; $i < count($players); $i++) {
            echo($players[$i]->getName() . "'s turn\n");
            $_score = $players[$i]->getLastScore();
            echo("Rolled: " . implode(", ", $_score) . "\n");
            echo("Score: " . $players[$i]->getPoint() . "\n");
            $numDice = $players[$i]->getNumDice();
            echo("Number of dice left: " . $numDice . "\n");
        }

        // remove player if no dice left
        for ($i = 0; $i < count($players); $i++) {
            $numDice = $players[$i]->getNumDice();
            if ($numDice <= 0) {
                $activePlayer--;
                $outPlayers[] = $players[$i];
                array_splice($players, $i, 1);
            }
        }

        echo("Number of active players: " . $activePlayer . "\n");
        echo("-------------------------------------------------\n");
    }

    $finalPlayer = array_merge($players, $outPlayers);
    $highestScore = max(array_column($finalPlayer, 'point'));
    $winnerPlayers = array_filter($finalPlayer, function ($p) use ($highestScore) {
        return $p->point === $highestScore;
    });

    echo "Winners: \n";
    foreach ($winnerPlayers as $player) {
        echo $player->getName() . " with " . $player->point . "(pts)\n";
    }
}

$numPlayers = 5;
$numDice = 5;

playDiceGame($numPlayers, $numDice);
