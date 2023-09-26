<?php

namespace App\Controller;

use App\Classes\Contracts\ExamServiceInterface;
use App\Classes\QuestionService;
use App\Entity\Exam;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    function __construct(
        private readonly QuestionService $questionService,
        private readonly ExamServiceInterface $examService
    )
    {}

    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route("/start", name="start")
     *
     * @return Response
     */
    public function startTest(Request $request) : Response 
    {
        $name = $request->get('name');
        if (!$name) {
            $this->addFlash('error', 'Please enter your name');
            return $this->redirect($this->generateUrl('app_index'));
        }
        $exam = $this->examService->startExam($name);

        $question = $this->questionService->getQuestion();
        
        return $this->render('index/question.html.twig', [
            'id' => $exam->getId(),
            'question' => $question
        ]);
    }

    /**
     * @Route("/exam/{id}", name="question")
     *
     * @return Response
     */
    public function question(Request $request, string $id) : Response 
    {
        $exam = $this->getDoctrine()->getRepository(Exam::class)->find($id);
        if (!$exam) {
            throw new Exception("Exam not found", Response::HTTP_NOT_FOUND);
        }
        if ($request->isMethod('POST')) {
            $question = $request->get('question');
            if (!$question) {
                throw new Exception("Empty question field", Response::HTTP_BAD_REQUEST);
                
            }
            $variants = $request->get('variants');
            if (empty($variants)) {
                $this->get('session')->getFlashBag()->add('error', 'choose variant');
                return $this->render('index/question.html.twig', [
                    'id' => $id,
                    'question' => $this->questionService->getQuestinById($question)
                ]);
            }
            $this->examService->addAnswers($exam, $variants, $question);
        }
        
        $question = $this->questionService->getQuestion($exam);
        if (!$question) {
            $this->examService->finishExam($exam);
            return $this->render('index/result.html.twig', [
                'exam' => $exam
            ]);
        }
        return $this->render('index/question.html.twig', [
            'id' => $id,
            'question' => $question
        ]);
    }

    /**
     * @Route("/results/{exam}", name="result")
     *
     * @return Response
     */
    public function result(Request $request, ?int $exam=null) : Response 
    {
        $exam = $this->getDoctrine()->getRepository(Exam::class)->find($exam);
        return $this->render('index/result.html.twig', [
            'exam' => $exam
        ]);
    }
}
