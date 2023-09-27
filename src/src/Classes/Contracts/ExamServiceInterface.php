<?php

namespace App\Classes\Contracts;

use App\Classes\Dto\AnswerDto;
use App\Entity\Exam;

interface ExamServiceInterface
{
    function getExamById(int $id): Exam;
    function startExam(string $name): Exam;
    function finishExam(Exam $exam);
    function addAnswers(AnswerDto $dto);
    function getAllCompleteExams(): array;
    function prepareResult(int $examId): array;
}
