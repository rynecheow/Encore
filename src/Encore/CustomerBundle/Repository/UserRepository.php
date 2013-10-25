<?php

namespace Encore\CustomerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    /*  Get user based on slug
     *  $slug = id OR encore_username
     */
    public function findUserBySlug($slug){
        return $this->getEntityManager()
            ->createQuery(" SELECT user FROM EncoreCustomerBundle:User user
                            WHERE user.id = :slug
                            OR user.encore_username = :slug
                            AND user.enabled = :enabled"
            )
            ->setParameters(array( 'slug' => $slug, 'enabled'=>1 ))
            ->getOneOrNullResult();
    }

   /*  Get user based on facebook id
    *  $facebook_uid = bigint
    */
//    public function findUserByFacebookUid($facebook_uid)
//    {
//        return $this->getEntityManager()->createQuery(' SELECT user
//                                                        FROM EncoreCustomerBundle:User user
//                                                        JOIN user.connectionSettings settings
//                                                        WHERE settings.connectedFacebookAt IS NOT NULL
//                                                        AND settings.disconnectedFacebookAt IS NULL
//                                                        AND settings.facebookUid = :facebook_uid'
//        )
//            ->setParameters(array('facebook_uid'=>$facebook_uid))
//            ->getOneOrNullResult();
//    }

    /* find user by email
     *
     * @params : string $email
     * @return User entity
     */
    public function findUserByEmail($email)
    {
        return $this->getEntityManager()->createQuery(" SELECT user
                                                        FROM EncoreCustomerBundle:User user,
                                                        EncoreCustomerBundle:UserEmail userEmail
                                                        WHERE user.id = userEmail.user
                                                        AND userEmail.email = :email")
            ->setParameters(array('email'=>$email))
            ->getOneOrNullResult();
    }


}
