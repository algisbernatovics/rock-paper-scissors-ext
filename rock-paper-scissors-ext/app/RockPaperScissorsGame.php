<?php

/**
This app incorporates the TESTMODE constant, a powerful feature that enhances testing capabilities.
In regular mode (TESTMODE = false), users are prompted with input prompts for natural interaction.
In testing mode (TESTMODE = true), user input prompts are intelligently removed for efficient testing procedures.
This ensures developers can focus on thorough testing without interruptions.
Experience seamless testing and user-friendly interaction with this app's versatile TESTMODE feature.
 **/

class RockPaperScissorsGame
{
    protected array $gameElements;
    protected array $players;
    protected const ROUNDS = 3;
    protected const TESTMODE = false;

    public function __construct()
    {
        $this->gameElements = $this->createElements();
        $this->players = $this->createPlayers();
    }

    public function start(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            for ($round = 1; $round <= self::ROUNDS; $round++) {
                echo "Round:$round with {$this->players[$i]->name}" . PHP_EOL;
                $this->setUserChoice($this->getUserChoice()) ;
                $this->setComputerChoice($this->getComputerChoice(),$i);
                $this->playRound($this->players[0], $this->players[$i]);
            }
            $this->determineWinner($this->players[0], $this->players[$i]);
        }
        $this->printResults();
    }

    public function playRound(stdClass $user, stdClass $computer): void
    {
        echo "$user->name Choose {$this->gameElements[$user->choice]->name}" . PHP_EOL;
        echo "$computer->name Choose {$this->gameElements[$computer->choice]->name}" . PHP_EOL;

        if ($this->gameElements[$user->choice]->name == $this->gameElements[$computer->choice]->name) {
            echo 'Its a draw!' . PHP_EOL;
        } else {

            if (in_array($this->gameElements[$computer->choice]->name, $this->gameElements[$user->choice]->beats)) {
                echo $user->name . ' Win!' . PHP_EOL;
                $this->setRoundPoints($user);
            }
            if (!in_array($this->gameElements[$computer->choice]->name, $this->gameElements[$user->choice]->beats)) {
                echo $computer->name . ' Win!' . PHP_EOL;
                $this->setRoundPoints($computer);
            }
        }
        echo PHP_EOL;
    }

    private function getUserChoice(): int
    {
        $gameElementsCount = count($this->gameElements);
        for ($i = 1; $i <= $gameElementsCount; $i++) {
            echo $i . ':' . $this->gameElements[$i]->name.' ';
        }

        echo PHP_EOL;

        if (self::TESTMODE) {
            $choice = NULL;
        }

        if (!self::TESTMODE) {
            $choice = readline("Enter choice (1-$gameElementsCount): ");

            $range = range(1, $gameElementsCount);
            while (!in_array($choice, $range)) {
                echo "Invalid choice. Please enter a number between 1 and $gameElementsCount." . PHP_EOL;
                $choice = readline("Enter choice (1-$gameElementsCount): ") . PHP_EOL;

            }
        }
        return intval($choice);
    }

    public function getComputerChoice(): int
    {
        return rand(1, count($this->gameElements));
    }

    private function createElements(): array
    {
        return [
            '1' => $this->createGameObj('Dynamite', $beats = ['Scissors', 'Lizard', 'Spock', 'Rock', 'Paper']),
            '2' => $this->createGameObj('Rock', $beats = ['Scissors', 'Lizard']),
            '3' => $this->createGameObj('Paper', $beats = ['Rock', 'Spock']),
            '4' => $this->createGameObj('Spock', $beats = ['Rock', 'Scissors']),
            '5' => $this->createGameObj('Scissors', $beats = ['Paper', 'Lizard']),
            '6' => $this->createGameObj('Lizard', $beats = ['Paper', 'Spock'])
        ];
    }

    private function createGameObj(string $name, array $beats): stdClass
    {
        $gameObj = new stdClass();
        $gameObj->name = $name;
        $gameObj->beats = $beats;
        return $gameObj;
    }

    private function createPlayers(): array
    {
        return [
            '0' => $this->createPlayerObj('Captain Copy Paste'),
            '1' => $this->createPlayerObj('Facepalm'),
            '2' => $this->createPlayerObj('Master of dynamite'),
            '3' => $this->createPlayerObj('The Papercraft Ninja'),
        ];
    }

    private function createPlayerObj(string $name): stdClass
    {
        $player = new stdClass();
        $player->name = $name;
        $player->points = 0;
        $player->wins = 0;
        $player->choice = 0;
        return $player;
    }

    public function determineWinner(stdClass $user, stdClass $computer): void
    {
        if ($user->points >= 2) {
            $user->wins++;
        } elseif ($computer->points >= 2) {
            $computer->wins++;
        }
        $user->points = 0;
        $computer->points = 0;
    }

    private function printResults(): void
    {
        foreach ($this->players as $player) {
            echo "$player->name have $player->wins Wins." . PHP_EOL;
        }

        echo PHP_EOL;

        foreach ($this->players as $player) {
            if ($player->wins === count($this->players)) {
                echo "$player->name Defeated all players!" . PHP_EOL;
                echo "$player->name Undisputed winner!" . PHP_EOL;
            }
        }
    }

    public function getGameElements(): array
    {
        return $this->gameElements;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function setUserChoice(int $choice):void
    {
        $this->players[0]->choice = $choice;
    }
    public function setComputerChoice(int $choice, int $playerNumber):void
    {
        $this->players[$playerNumber]->choice = $choice;
    }
    public function setRoundPoints(stdClass $player):void
    {
        $player->points ++;
    }
}

$game = (new RockPaperScissorsGame())->start();
