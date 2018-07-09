<?php

namespace ProductDisplay\Service;

use ProductDisplay\Entity\Product;
use ProductDisplay\Entity\ProductMaster;
use ProductDisplay\Entity\ProductColorImage;
use ProductDisplay\Entity\Image;
use ProductDisplay\Service\Interfacef\ProductManagerInterface;
use UserManagement\Entity\User;
use Zend\Filter\StaticFilter;
use ProductDisplay\Entity\Comment;
use ProductDisplay\Entity\Review;


class ProductManager implements ProductManagerInterface
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $color = [
        ProductMaster::WHITE => 'White',
        ProductMaster::BLACK => 'Black',
        ProductMaster::YELLOW => 'Yellow',
        ProductMaster::RED => 'Red',
        ProductMaster::GREEN => 'Green',
        ProductMaster::PURPLE => 'Purple',
        ProductMaster::ORANGE => 'Orange',
        ProductMaster::BLUE => 'Blue',
        ProductMaster::GREY => 'Grey',
    ];
    private $entityManager;

    // Constructor is used to inject dependencies into the service.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCommentCountStr($product)
    {
        $commentCount = count($product->getComments());
        if ($commentCount == 0)
            return 'No comments';
        else if ($commentCount == 1)
            return '1 comment';
        else
            return $commentCount . ' comments';
    }

    // This method adds a new comment to .
    public function addComment($product, $data)
    {
        // Create new Comment entity.
        $user = $this->entityManager->
            getRepository(User::class)->find($data['user_id']);
        
        $comment = new Comment();
        $comment->setProduct($product);
        $comment->setUser($user);
        $comment->setContent($data['content']);
        
        $currentDate = date('Y-m-d H:i:s');
        $comment->setDateCreated($currentDate);
        $this->entityManager->persist($comment);

        // Add the entity to entity manager.

        if (!empty($data['comment_id'])) {
            $parent = $this->entityManager
                ->getRepository(Comment::class)->find($data['comment_id']);
            
            $comment->setParent($parent);
        }

        // Apply changes.
        $this->entityManager->flush();

        return $comment;
    }

    public function addReview($product, $data)
    {
        $user = $this->entityManager
            ->getRepository(User::Class)->find($data['user_id']);
        $review = new Review();
        $review->setUser($user);
        $review->setContent($data['content']);
        $review->setRate($data['rate']);
        $currentDate = date('Y-m-d H:i:s');
        $review->setDateCreated($currentDate);
        $review->setProduct($product);

        // Add the entity to entity manager.
        $this->entityManager->persist($review);

        // Apply changes.
        $this->entityManager->flush();

        return $review;
    }

    public function deleteComment($data)
    {
        $comment = $this->entityManager->
        getRepository(Comment::class)->find($data['comment_id']);

        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }
}
