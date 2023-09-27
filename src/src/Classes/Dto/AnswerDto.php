<?php

namespace App\Classes\Dto;

use App\Entity\Exam;

class AnswerDto
{
    private readonly Exam $exam;

    private readonly int $questionId;

    private readonly array $variants;

    function __construct(Exam $exam, int $questionId, array $variants)
    {
        $this->exam = $exam;
        $this->questionId = $questionId;
        $this->variants = $variants;
    }

    public function getExam() : Exam 
    {
        return $this->exam;
    }

    public function getQuestion() : int {
        return $this->questionId;
    }

    public function getVariants() : array {
        return $this->variants;
    }
}