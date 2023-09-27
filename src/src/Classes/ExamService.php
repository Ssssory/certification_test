<?php

namespace App\Classes;

use App\Classes\Contracts\ExamServiceInterface;
use App\Classes\Dto\AnswerDto;
use App\Entity\Exam;
use App\Entity\History;
use App\Repository\AnswerRepository;
use App\Repository\ExamRepository;
use App\Repository\HistoryRepository;

final class ExamService implements ExamServiceInterface
{
    const COUNT_LAST_EXAM = 10;

    function __construct(
        private ExamRepository $examRepository,
        private HistoryRepository $historyRepository,
        private QuestionService $questionService,
        private AnswerRepository $answerRepository
    )
    {}

    public function getExamById(int $id) : Exam 
    {
        return $this->examRepository->find($id);
    }

    public function startExam(string $name) : Exam 
    {
        $exam = new Exam();
        $exam->setName($name);
        $exam->setComplete(false);
        $exam->setDateStart(new \DateTime());

        $this->examRepository->add($exam);
        return $exam;
    }

    public function finishExam(Exam $exam) : void 
    {
        $exam->setComplete(true);
        $this->examRepository->add($exam);
    }

    public function addAnswers(AnswerDto $dto): void
    {
        if ($this->historyRepository->findOneBy(['exam' => $dto->getExam(), 'question' => $dto->getQuestion()])) {
            return;
        }
        $historyLast = $this->historyRepository->getLastAnswer($dto->getExam());
        $step = $historyLast ? $historyLast->getStep() + 1 : 1;
        $question = $this->questionService->getQuestinById($dto->getQuestion());
        foreach ($dto->getVariants() as $key => $variant) {
            $history = new History();
            $history->setExam($dto->getExam());
            $history->setQuestion($question);
            $history->setAnswer($this->answerRepository->find($key));
            $history->setStep($step);
            $this->historyRepository->add($history);
        }
    }

    public function getAllCompleteExams() : array
    {
        return $this->examRepository->findBy(['complete' => true],['id' => 'desc'], self::COUNT_LAST_EXAM);
    }

    public function prepareResult(int $examId): array
    {
        $exam = $this->examRepository->find($examId);
        $answers = $this->historyRepository->getGroupHistoryByExam($exam);

        $result = [];
        foreach ($answers as $answer) {
            if (!isset($result[$answer->getStep()])) {
                $result[$answer->getStep()] = [
                    'question' => $answer->getQuestion()->getText(),
                    'answer' => $answer->getRight(),
                ];
            }
            if ($result[$answer->getStep()]['answer'] === true && $answer->getRight() === false) {
                $result[$answer->getStep()]['answer'] = false;
            }
        }
        return $result;
    }
}
