<?php

namespace App\Classes\Contracts;

use App\Entity\Exam;

interface ExamServiceInterface
{
    function startExam(string $name);
    function finishExam(Exam $exam);
    function addAnswers(Exam $exam, array $variants, int $questionId);
}
