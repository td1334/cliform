<?php

declare(strict_types=1);

namespace td1334\cliform;


class Cliform
{
    public array $questions;

    public function __construct() {
        $this->questions = [];
    }
    public function add($tag, \td1334\cliform\CliFormQuestion $question): Cliform {
        if(isset( $this->questions[$tag] ))
            throw new \Exception("Duplicate tag ($tag)");

        $this->questions[$tag] = $question;
        return $this;
    }

    public function getQuestion($tag): CliFormQuestion {
        if(!isset( $this->questions[$tag] ))
            throw new \Exception("Unknown tag ($tag)");
        return $this->questions[$tag];
    }

    public function run():Cliform {
        /* @var $question CliFormQuestion */
        foreach($this->questions as $question) {
            $question-> run();
        }
        return $this;
    }

    public function getValue(string $tag):string {
        if(!isset( $this->questions[$tag] ))
            throw new \Exception("Unknown tag ($tag)");

        /* @var $question CliFormQuestion */
        $question = $this->questions[$tag];
        return $question->response;
    }
}