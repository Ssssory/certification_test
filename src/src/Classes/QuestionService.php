<?php 

namespace App\Classes;

use App\Classes\Contracts\QuestionServiceInterface;
use App\Entity\Exam;
use App\Entity\Question;
use App\Repository\HistoryRepository;
use App\Repository\QuestionRepository;

final class QuestionService implements QuestionServiceInterface
{
    const MAX_QUESTIONS = 3;

    function __construct(
        private QuestionRepository $questionRepository,
        private HistoryRepository $historyRepository
    )
    {}

    public function getQuestinById(int $id) : Question 
    {
        return $this->questionRepository->find($id);
    }

    public function getQuestion(Exam $exam=null) : ?Question 
    {
        if (!$exam) {
            return $this->getRandomQuestion();
        }
        return $this->getNewQuestion($exam);
    }

    private function getRandomQuestion() : Question 
    {
        $allQuestions = $this->questionRepository->findAll();
        shuffle($allQuestions);
        return array_pop($allQuestions);
    }

    private function getNewQuestion(Exam $exam) : ?Question 
    {
        $last = $this->historyRepository->getLastAnswer($exam);
        if($last && $last->getStep() >= self::MAX_QUESTIONS) {
            return null;
        }
        $questions = $this->questionRepository->getAvailableQuestions($exam);

        shuffle($questions);
        return array_pop($questions);
    }
}
