<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class SarrishPlayers
 * @package Hackathon\PlayerIA
 * @author SWANN BRUNET
 */
class SarrishPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {

        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Choice           ?    $this->result->getLastChoiceFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Choice ?    $this->result->getLastChoiceFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get all the Choices          ?    $this->result->getChoicesFor($this->mySide)
        // How to get the opponent all Choice ?    $this->result->getChoicesFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get the stats                ?    $this->result->getStats()
        // How to get the stats for me         ?    $this->result->getStatsFor($this->mySide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // How to get the stats for the oppo   ?    $this->result->getStatsFor($this->opponentSide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // -------------------------------------    -----------------------------------------------------
        // How to get the number of round      ?    $this->result->getNbRound()
        // -------------------------------------    -----------------------------------------------------
        // How can i display the result of each round ? $this->prettyDisplay()
        // -------------------------------------    -----------------------------------------------------

        if ($this->result->getNbRound() == 0) {
            return parent::paperChoice();
        } else {
            if ($this->result->getNbRound() == 1) {
                if ($this->result->getLastScoreFor($this->opponentSide) == parent::paperChoice()) {
                    return parent::scissorsChoice();
                } else {
                    if($this->result->getLastScoreFor($this->opponentSide) == parent::scissorsChoice()){
                        return parent::rockChoice();
                } else {
                    if ($this->result->getLastScoreFor($this->opponentSide) == parent::rockChoice()){
                        return parent::paperChoice();
                    }
                }
                }
            } else {
                $stat = $this->result->getChoicesFor($this->opponentSide);
                $paper = 0;
                $rock = 0;
                $scissors = 0;
                foreach ($stat as &$value) {
                    if ($value == parent::rockChoice()){
                        $rock += 1;
                    } 
                    if ($value == parent::paperChoice()){
                        $paper += 1;
                    }
                    if ($value == parent::scissorsChoice()){
                        $scissors += 1;
                    }
                 }
                if ($paper > $rock + $scissors) {
                    return parent::scissorsChoice();
                }
                if ($scissors > $rock + $paper) {
                    return parent::rockChoice();
                }
                if ($rock > $paper + $scissors) {
                    return parent::paperChoice();
                }
            }
            return parent::paperChoice();
        }
    }
};
