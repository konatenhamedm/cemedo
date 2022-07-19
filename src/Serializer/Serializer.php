<?php

namespace App\Serializer;

use App\Entity\Media;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use App\Services\FileUploader;
use App\Entity\Patient;

final class Serializer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private  $fileUploader;
    private const ALREADY_CALLED = 'SUPERHEROES_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(FileUploader $fileUploader) {
        $this->fileUploader = $fileUploader;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool {
        return !isset($context[self::ALREADY_CALLED]) && $data instanceof Patient;
    }

    public function normalize($object, ?string $format = null, array $context = []) {
        $context[self::ALREADY_CALLED] = true;

        // update the cover with the url
        if($object->getPieceIdRecto())
            $object->setPieceIdRecto($this->fileUploader->getUrl($object->getPieceIdRecto()))  ;
        if ($object->getPieceIdVerso())
            $object->setPieceIdVerso($this->fileUploader->getUrl($object->getPieceIdVerso()))  ;
        if ($object->getAssuranceRecto())
            $object->setAssuranceRecto($this->fileUploader->getUrl($object->getAssuranceRecto()))  ;
        if ($object->getAssuranceVerso())
            $object->setAssuranceVerso($this->fileUploader->getUrl($object->getAssuranceVerso()))  ;

        return $this->normalizer->normalize($object, $format, $context);
    }
}