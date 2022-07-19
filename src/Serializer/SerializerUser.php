<?php

namespace App\Serializer;

use App\Entity\Administrateur;
use App\Entity\Gerant;
use App\Entity\Infirmier;
use App\Entity\Medecin;
use App\Entity\Media;
use App\Entity\Pharmacien;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use App\Services\FileUploader;
use App\Entity\Patient;

final class SerializerUser implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private  $fileUploader;
    private const ALREADY_CALLED = 'SUPERHEROES_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(FileUploader $fileUploader) {
        $this->fileUploader = $fileUploader;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool {
        return !isset($context[self::ALREADY_CALLED]) && ($data instanceof Administrateur || $data instanceof Infirmier || $data instanceof Pharmacien
            || $data instanceof Gerant || $data instanceof Medecin);
    }

    public function normalize($object, ?string $format = null, array $context = []) {
        $context[self::ALREADY_CALLED] = true;

        // update the cover with the url
        if ($object->getPhoto()){

            $object->setPhoto($this->fileUploader->getUrl($object->getPhoto()));
        }


        return $this->normalizer->normalize($object, $format, $context);
    }
}