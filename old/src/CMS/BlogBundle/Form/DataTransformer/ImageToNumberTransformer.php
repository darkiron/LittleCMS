<?php 
// src/AppBundle/Form/DataTransformer/IssueToNumberTransformer.php
namespace CMS\BlogBundle\Form\DataTransformer;

use CMS\BlogBundle\Entity\Image;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ImageToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($image)
    {
        if (null === $image) {
            return '';
        }

        return $image->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($imageNumber)
    {
        // no issue number? It's optional, so that's ok
        if (!$imageNumber) {
            return;
        }

        $image = $this->manager
            ->getRepository('CMSBlogBundle:Image')
            // query for the issue with this id
            ->find($imageNumber)
        ;

        if (null === $image) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $imageNumber
            ));
        }

        return $image;
    }
}