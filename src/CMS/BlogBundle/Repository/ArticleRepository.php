<?php


namespace CMS\BlogBundle\Repository;

use Doctrine\ORM\Query\ResultSetMapping;
/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{

	public function countAll(){
		$query = $this->createQueryBuilder('a')
					  ->select('count(a)')
					  ->andWhere('a.category != 5')
					  ->where('a.datepublication <= :date')
					  ->setParameter('date', new \Datetime)
	    			  ->getQuery();

		return $query->getSingleScalarResult();
	}

	public function countByCat($category){
		$query = $this->createQueryBuilder('a')
					  ->select('count(a)')
					  ->where('a.category = :category')
					  ->setParameter('category',$category)
					  ->andWhere('a.datepublication <= :date')
					  ->setParameter('date', new \Datetime)
	    			  ->getQuery();

		return $query->getSingleScalarResult();
	}

	public function search($query){

		$old = $this->_em->getConnection();

		$stmt = $old->prepare("SELECT article_id FROM search WHERE MATCH(titre, description) AGAINST (:query);");
		$stmt->bindValue(':query',$old->quote($query));
		$stmt->execute();

		return $stmt->fetchAll() ;

	}

	public function getList($nb_result, $offset, $arrayid = null){

		$query = $this->createQueryBuilder('a')
					  ->select('a')
					  ->leftJoin('a.replies','r')
					  ->leftJoin('a.user','u')
					  ->leftJoin('a.category','c')
					  ->addSelect('r')
					  ->addSelect('u')
					  ->addSelect('c')
					  ->where('a.datepublication <= :date')
					  ->andWhere('a.category != 5')
					  ->setParameter('date', new \Datetime)
					  ->setMaxResults($nb_result)
					  ->setFirstResult($offset)
					  ->orderBy('a.datepublication','DESC');

		if(is_array($arrayid)){
			$query->andWhere('a.id IN (:id)')->setParameter('id', $arrayid);
		}
	    			  
		return $query->getQuery()->getResult();
	}

	public function getByCat($cat,$nb_result, $offset){

		$query = $this->createQueryBuilder('a')
					  ->select('a')
					  ->leftJoin('a.replies','r')
					  ->leftJoin('a.user','u')
					  ->leftJoin('a.category','c')
					  ->addSelect('r')
					  ->addSelect('u')
					  ->addSelect('c')
					  ->where('a.datepublication <= :date')
					  ->setParameter('date', new \Datetime)
					  ->andWhere('a.category = :cat')
					  ->setParameter('cat', $cat)
					  ->setMaxResults($nb_result)
					  ->setFirstResult($offset)
					  ->orderBy('a.datepublication','DESC');

	    			  
		return $query->getQuery()->getResult();
	}

	public function random(){
	
// build rsm here

		$query = 'SELECT id as id FROM article ORDER BY RAND() LIMIT 1';
		$connection = $result = $this->_em->getConnection();
		$result = $connection->fetchArray($query);
		
		return $this->createQueryBuilder('a')
					  ->where('a.id = :id')
					  ->setParameter('id', $result[0])
					  ->andWhere('a.datepublication <= :date')
					  ->setParameter('date', new \Datetime)
					  ->andWhere('a.category != 5')
					  ->getQuery()
					  ->getSingleResult();

	}

	public function getAbout(){
		$query = $this->createQueryBuilder('a')
					  ->select('a')
					  ->leftJoin('a.category','c')
					  ->leftJoin('a.user','u')
					  ->addSelect('u')
					  ->where('a.datepublication <= :date')
					  ->setParameter('date', new \Datetime)
					  ->andWhere('a.category = :cat')
					  ->setParameter('cat', 5)
					  ->orderBy('a.datepublication','DESC');

	    			  
		return $query->getQuery()->getResult();
	}
}
