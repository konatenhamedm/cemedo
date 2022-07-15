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

        if (($resourceClass === PageCarnetSante::class || $resourceClass === FichierMedical::class
                || $resourceClass === MembreFamille::class || $resourceClass === Notification::class
                ||  $resourceClass === Adresse::class || $resourceClass === Affection::class
                || $resourceClass === Ordonnance::class) && !$this->auth->isGranted("ROLE_ADMIN")){
            $rootAlias = $queryBuilder->getRootAliases()[0];
                if ($resourceClass instanceof  MembreFamille ){
                    $queryBuilder->andWhere("$rootAlias.patient = :user");
                }else{
                    $queryBuilder->andWhere("$rootAlias.assure = :user");
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