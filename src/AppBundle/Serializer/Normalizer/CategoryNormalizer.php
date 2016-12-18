<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Category;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * User normalizer
 */
class CategoryNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = NULL, array $context = array())
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = NULL)
    {
        return $data instanceof Category;
    }
}
