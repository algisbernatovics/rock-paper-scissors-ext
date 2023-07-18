<?php

require_once '../app/Models/Player.php';
require_once '../app/Models/GameElement.php';

class RockPaperScissorsGame
{
    protected array $gameElements;
    protected Player $user;
    protected array $computerPlayers;
    protected const ROUNDS = 3;

    public function __construct(Player $user, array $computerPlayers, array $gameElements)
    {
        $this->gameElements = $gameElements;
        $this->user = $user;
        $this->computerPlayers = $computerPlayers;
    }

    public function start(): void
    {
        foreach ($this->computerPlayers as $player) {
            for ($round = 1; $round <= self::ROUNDS; $round++) {
                echo "Round: $round with {$player->getName()}" . PHP_EOL;
                $userChoice = $this->getUserChoice();
                $player->setChoice($this->getComputerChoice());
                $this->playRound($this->user, $player, $userChoice);
            }
            $this->determineWinner($this->user, $player);
        }
        $this->printResults();
    }

    public function playRound(Player $user, Player $opponent, int $userChoice): void
    {
        $userElement = $this->gameElements[$userChoice];
        $computerElement = $this->gameElements[$opponent->getChoice()];

        echo "{$user->getName()} chooses {$userElement->getName()}" . PHP_EOL;
        echo "{$opponent->getName()} chooses {$computerElement->getName()}" . PHP_EOL;

        if ($userElement->beats($computerElement)) {
            echo "{$user->getName()} wins!" . PHP_EOL;
            $user->increasePoints();
        } elseif ($computerElement->beats($userElement)) {
            echo "{$opponent->getName()} wins!" . PHP_EOL;
            $opponent->increasePoints();
        } else {
            echo "It's a draw!" . PHP_EOL;
        }
        echo PHP_EOL;
    }

    private function getUserChoice(): int
    {
        $gameElementsCount = count($this->gameElements);
        $choice = readline("{$this->user->getName()}, enter choice (1-$gameElementsCount): ");
        $range = range(1, $gameElementsCount);

        while (!in_array($choice, $range)) {
            echo "Invalid choice. Please enter a number between 1 and $gameElementsCount." . PHP_EOL;
            $choice = readline("{$this->user->getName()}, enter choice (1-$gameElementsCount): ");
        }
        return intval($choice);
    }

    public function getComputerChoice(): int
    {
        return rand(1, count($this->gameElements));
    }

    public function determineWinner(Player $user, Player $opponent): void
    {
        if ($user->getPoints() >= 2) {
            $user->increaseWins();
        } elseif ($opponent->getPoints() >= 2) {
            $opponent->increaseWins();
        }
        $user->resetPoints();
        $opponent->resetPoints();
    }

    private function printResults(): void
    {
        echo "{$this->user->getName()} has {$this->user->getWins()} win(s)." . PHP_EOL;
        foreach ($this->computerPlayers as $player) {
            echo "{$player->getName()} has {$player->getWins()} win(s)." . PHP_EOL;
        }
        echo PHP_EOL;
    }
}

$computerUser = new Player('Captain Copy Paste');

$computerPlayers = [
    new Player('Facepalm (Bot)'),
    new Player('Master of Dynamite (Bot)'),
];

$gameElements = [
    1 => new GameElement('Dynamite', $beats = ['Scissors', 'Lizard', 'Spock', 'Rock', 'Paper']),
    2 => new GameElement('Rock', $beats = ['Scissors', 'Lizard']),
    3 => new GameElement('Paper', $beats = ['Rock', 'Spock']),
    4 => new GameElement('Spock', $beats = ['Rock', 'Scissors']),
    5 => new GameElement('Scissors', $beats = ['Paper', 'Lizard']),
    6 => new GameElement('Lizard', $beats = ['Paper', 'Spock'])
];

$game = (new RockPaperScissorsGame($computerUser, $computerPlayers, $gameElements))->start();
