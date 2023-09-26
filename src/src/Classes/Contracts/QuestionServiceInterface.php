<?php

namespace App\Classes\Contracts;

interface QuestionServiceInterface
{
    function getQuestion();
    function getQuestinById(int $id);
    
}