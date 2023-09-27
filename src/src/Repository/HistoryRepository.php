<?php

namespace App\Repository;

use App\Entity\Exam;
use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<History>
 *
 * @method History|null find($id, $lockMode = null, $lockVersion = null)
 * @method History|null findOneBy(array $criteria, array $orderBy = null)
 * @method History[]    findAll()
 * @method History[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(History $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(History $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getLastAnswer(Exam $exam) : ?History
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.step', 'DESC')
            ->andWhere('h.exam = :exam')
            ->setParameter('exam', $exam)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getHistoryByExam(Exam $exam) : array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exam = :exam')
            ->setParameter('exam', $exam)
            ->orderBy('h.step', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getGroupHistoryByExam(Exam $exam) : array
    {
        return $this->createQueryBuilder('h')
            ->join('h.question', 'q')
            ->join('h.answer', 'a')
            ->addSelect('q')
            ->addSelect('a')
            ->andWhere('h.exam = :exam')
            ->setParameter('exam', $exam)
            ->orderBy('h.step', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
