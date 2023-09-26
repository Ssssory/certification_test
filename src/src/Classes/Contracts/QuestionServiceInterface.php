<?php

namespace App\Classes\Contracts;

use App\Entity\Question;

interface QuestionServiceInterface
{
    function getQuestion(): ?Question;
    function getQuestinById(int $id): Question;
    
}