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

    private function calculeMyStat($underound)
    {
        $myStat = $this->result->getChoicesFor($this->mySide);
        for ($i = 1; $i <= $underound; $i++) {
            array_pop($myStat);
        }
        $paper = 0;
        $rock = 0;
        $scissors = 0;
        foreach ($myStat as &$value) {
            if ($value == parent::rockChoice()) {
                $rock += 1;
            }
            if ($value == parent::paperChoice()) {
                $paper += 1;
            }
            if ($value == parent::scissorsChoice()) {
                $scissors += 1;
            }
        }
        return [$rock, $paper, $scissors];
    }

    public function getChoice()
    {

        if ($this->result->getNbRound() == 0) {
            return parent::paperChoice();
        } else {
            if ($this->result->getNbRound() == 1) {
                if ($this->result->getLastScoreFor($this->opponentSide) == parent::paperChoice()) {
                    return parent::scissorsChoice();
                } else {
                    if ($this->result->getLastScoreFor($this->opponentSide) == parent::scissorsChoice()) {
                        return parent::rockChoice();
                    } else {
                        if ($this->result->getLastScoreFor($this->opponentSide) == parent::rockChoice()) {
                            return parent::paperChoice();
                        }
                    }
                }
            } else {
                $stat = $this->result->getChoicesFor($this->opponentSide);
                $myStat = $this->result->getChoicesFor($this->mySide);
                $paper = 0;
                $rock = 0;
                $scissors = 0;
                //Verifie si l'utilisateur a une grosse prédominance 
                foreach ($stat as &$value) {
                    if ($value == parent::rockChoice()) {
                        $rock += 1;
                    }
                    if ($value == parent::paperChoice()) {
                        $paper += 1;
                    }
                    if ($value == parent::scissorsChoice()) {
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
                $round = $this->result->getNbRound();

                //Test if oponent use my last choice
                for ($i = 1; $i <= 10; $i++) {
                    if ($round > 4 + $i) {
                        if ($stat[$round - 1] == $myStat[$round - (1 + $i)] && $stat[$round - 2] == $myStat[$round - (2 + $i)] && $stat[$round - 3] == $myStat[$round - (3 + $i)]) {
                            $lastChoice = $myStat[$round -  $i];
                            if ($lastChoice == parent::paperChoice()) {
                                return parent::scissorsChoice();
                            }
                            if ($lastChoice == parent::scissorsChoice()) {
                                return parent::rockChoice();
                            }
                            if ($lastChoice == parent::rockChoice()) {
                                return parent::paperChoice();
                            }
                        }
                    }
                }

                //Verifie si l'utilisateur utilise un system de state
                $success = true;
                if ($round > 3) {
                    for ($i = 1; $i <= 3; $i++) {
                        $test = false;
                        $res = $this->calculeMyStat($i);
                        if ($res[0] > ($res[1] + $res[2]) / 2) {
                            $test = $stat[$round - $i] == parent::paperChoice();
                        }
                        if ($res[1] > ($res[0] + $res[2]) / 2) {
                            $test = $stat[$round - $i] == parent::scissorsChoice();
                        }
                        if ($res[2] > ($res[1] + $res[0]) / 2) {
                            $test = $stat[$round - $i] == parent::rockChoice();
                        }
                        $success = $success && $test;
                    }
                    if ($success) {
                        $res = $this->calculeMyStat(0);
                        if ($res[0] > ($res[1] + $res[2]) / 2) {
                            return parent::paperChoice();
                        }
                        if ($res[1] > ($res[0] + $res[2]) / 2) {
                            return parent::scissorsChoice();
                        }
                        if ($res[2] > ($res[1] + $res[0]) / 2) {
                            return parent::rockChoice();
                        }
                    }
                }


                /* LAST CHOICE ONLY FOR END */
                $lastChoice = $this->result->getLastChoiceFor($this->opponentSide);
                if ($lastChoice == parent::paperChoice()) {
                    return parent::rockChoice();
                }
                if ($lastChoice == parent::scissorsChoice()) {
                    return parent::paperChoice();
                }
                if ($lastChoice == parent::rockChoice()) {
                    return parent::scissorsChoice();
                }
            }
            return parent::paperChoice();
        }
    }
};
