<?php

namespace  App\Doctrine;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Adresse;
use App\Entity\Affection;
use App\Entity\Facture;
use App\Entity\FichierMedical;
use App\Entity\MembreFamille;
use App\Entity\Notification;
use App\Entity\Ordonnance;
use App\Entity\PageCarnetSante;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface,QueryItemExtensionInterface{

    private $security;
    private $auth;

    public function __construct(Security $security,AuthorizationCheckerInterface $checker)
    {
    $this->security = $security;
    $this->auth = $checker;
    }

    private function addWhere(QueryBuilder $queryBuilder,string $resourceClass){
        $user = $this->security->getUser();

        if (($resourceClass === Affection::class || $resourceClass === Ordonnance::class) && !$this->auth->isGranted("ROLE_ADMIN")){

            $rootAlias = $queryBuilder->getRootAliases()[0];

            if ($resourceClass === Affection::class){
                $queryBuilder->andWhere("$rootAlias.antecedants = :user");

            }elseif ($resourceClass === Ordonnance::class || $resourceClass === Adresse::class || $resourceClass === Facture::class){
                $queryBuilder->andWhere("$rootAlias.assure = :user");
            }
            elseif ($resourceClass === MembreFamille::class || $resourceClass === Notification::class){
                $queryBuilder->andWhere("$rootAlias.patient = :user");
            }
            elseif ($resourceClass === FichierMedical::class){
                $queryBuilder->andWhere("$rootAlias.dossierMedical = :user");
            }
            elseif ($resourceClass === PageCarnetSante::class){
                $queryBuilder->andWhere("$rootAlias.carnetSante = :user");
            }
            $queryBuilder->setParameter("user",$user);

            /* dd($queryBuilder);*/
        }
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {

      $this->addWhere($queryBuilder,$resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->addWhere($queryBuilder,$resourceClass);
    }
}