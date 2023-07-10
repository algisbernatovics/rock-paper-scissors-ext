<?php

require 'RockPaperScissorsGame.php';

use PHPUnit\Framework\TestCase;

class RockPaperScissorsTest extends TestCase
{
    public function testCreatePlayers()
    {
        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();

        $this->assertEquals("Captain Copy Paste", $players[0]->name);
        $this->assertEquals("0", $players[0]->points);
        $this->assertEquals("0", $players[0]->wins);
        $this->assertEquals("0", $players[0]->choice);
        $this->assertEquals("Facepalm", $players[1]->name);
        $this->assertEquals("0", $players[1]->points);
        $this->assertEquals("0", $players[1]->wins);
        $this->assertEquals("0", $players[1]->choice);
        $this->assertEquals("Master of dynamite", $players[2]->name);
        $this->assertEquals("0", $players[2]->points);
        $this->assertEquals("0", $players[2]->wins);
        $this->assertEquals("0", $players[2]->choice);
        $this->assertEquals("The Papercraft Ninja", $players[3]->name);
        $this->assertEquals("0", $players[3]->points);
        $this->assertEquals("0", $players[3]->wins);
        $this->assertEquals("0", $players[3]->choice);
    }

    public function testCreateGameElements()
    {
        $game = new RockPaperScissorsGame();
        $gameElements = $game->getGameElements();

        $this->assertEquals('Dynamite', $gameElements[1]->name);
        $this->assertEquals(['Scissors', 'Lizard', 'Spock', 'Rock', 'Paper'], $gameElements[1]->beats);
        $this->assertEquals('Rock', $gameElements[2]->name);
        $this->assertEquals(['Scissors', 'Lizard'], $gameElements[2]->beats);
        $this->assertEquals('Paper', $gameElements[3]->name);
        $this->assertEquals(['Rock', 'Spock'], $gameElements[3]->beats);
        $this->assertEquals('Spock', $gameElements[4]->name);
        $this->assertEquals(['Rock', 'Scissors'], $gameElements[4]->beats);
        $this->assertEquals('Scissors', $gameElements[5]->name);
        $this->assertEquals(['Paper', 'Lizard'], $gameElements[5]->beats);
        $this->assertEquals('Lizard', $gameElements[6]->name);
        $this->assertEquals(['Paper', 'Spock'], $gameElements[6]->beats);
    }

    public function testComputerChoice()
    {
        $game = new RockPaperScissorsGame();
        $choice = $game->getComputerChoice();

        $minRange = 1;
        $maxRange = 6;

        $this->assertGreaterThanOrEqual($minRange, $choice);
        $this->assertLessThanOrEqual($maxRange, $choice);
        $this->assertGreaterThanOrEqual($minRange, $choice);
        $this->assertLessThanOrEqual($maxRange, $choice);
        $this->assertGreaterThanOrEqual($minRange, $choice);
        $this->assertLessThanOrEqual($maxRange, $choice);
        $this->assertGreaterThanOrEqual($minRange, $choice);
        $this->assertLessThanOrEqual($maxRange, $choice);
        $this->assertGreaterThanOrEqual($minRange, $choice);
        $this->assertLessThanOrEqual($maxRange, $choice);
        $this->assertGreaterThanOrEqual($minRange, $choice);
        $this->assertLessThanOrEqual($maxRange, $choice);
    }

    public function testUserChoiceElement()
    {
        $game = new RockPaperScissorsGame();
        $game->setComputerChoice(1, 0);
        $gameElements = $game->getGameElements();
        $gamePlayers = $game->getPlayers();
        $this->assertEquals('Dynamite', $gameElements[$gamePlayers[0]->choice]->name);
    }

    public function testComputerChoiceElement()
    {
        $game = new RockPaperScissorsGame();
        $game->setComputerChoice(1, 1);
        $gameElements = $game->getGameElements();
        $gamePlayers = $game->getPlayers();
        $this->assertEquals('Dynamite', $gameElements[$gamePlayers[1]->choice]->name);

        $game = new RockPaperScissorsGame();
        $game->setComputerChoice(1, 2);
        $gameElements = $game->getGameElements();
        $gamePlayers = $game->getPlayers();
        $this->assertEquals('Dynamite', $gameElements[$gamePlayers[2]->choice]->name);

        $game = new RockPaperScissorsGame();
        $game->setComputerChoice(1, 3);
        $gameElements = $game->getGameElements();
        $gamePlayers = $game->getPlayers();
        $this->assertEquals('Dynamite', $gameElements[$gamePlayers[3]->choice]->name);
    }

    public function testUserRoundWin()
    {
        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setUserChoice(1);
        $game->setComputerChoice(2, 1);
        $game->playRound($players[0], $players[1]);
        $this->assertEquals('1', $players[0]->points);
    }

    public function testComputerRoundWin()
    {
        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setUserChoice(2);
        $game->setComputerChoice(1, 1);
        $game->playRound($players[0], $players[1]);
        $this->assertEquals('1', $players[1]->points);

        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setUserChoice(2);
        $game->setComputerChoice(1, 2);
        $game->playRound($players[0], $players[2]);
        $this->assertEquals('1', $players[2]->points);

        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setUserChoice(2);
        $game->setComputerChoice(1, 3);
        $game->playRound($players[0], $players[3]);
        $this->assertEquals('1', $players[3]->points);
    }
    public function testDeterminateUserWinner()
    {
        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setRoundPoints($players[0]);
        $game->setRoundPoints($players[0]);
        $game->setRoundPoints($players[0]);
        $game->determineWinner($players[0],$players[1]);
        $this->assertEquals('1', $players[0]->wins);
    }
    public function testDeterminateComputerWinner()
    {
        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setRoundPoints($players[1]);
        $game->setRoundPoints($players[1]);
        $game->setRoundPoints($players[1]);
        $game->determineWinner($players[1],$players[0]);
        $this->assertEquals('1', $players[1]->wins);

        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setRoundPoints($players[2]);
        $game->setRoundPoints($players[2]);
        $game->setRoundPoints($players[2]);
        $game->determineWinner($players[2],$players[0]);
        $this->assertEquals('1', $players[2]->wins);

        $game = new RockPaperScissorsGame();
        $players = $game->getPlayers();
        $game->setRoundPoints($players[3]);
        $game->setRoundPoints($players[3]);
        $game->setRoundPoints($players[3]);
        $game->determineWinner($players[3],$players[0]);
        $this->assertEquals('1', $players[3]->wins);
    }
}

