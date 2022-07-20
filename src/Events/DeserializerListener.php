<?php
namespace  App\Events;

use ApiPlatform\Core\EventListener\DeserializeListener as DecoratedListener;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Core\Util\RequestAttributesExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DeserializerListener {
    private $decorated;
    private $contextBuilder;
    private $denormalizable;
    public function __construct(DenormalizerInterface $denormalizable, DecoratedListener $decorated,SerializerContextBuilderInterface $contextBuilder)
    {
     $this->decorated = $decorated;
     $this->contextBuilder = $contextBuilder;
     $this->denormalizable = $denormalizable;
    }

    public function onKernelRequest(RequestEvent $event):void
    {
       $request = $event->getRequest();
       if ($request->isMethodCacheable() || $request->isMethod(Request::METHOD_DELETE)){
           return;
       }
       if($request->getContentType() === 'form' || $request->getContentType() === 'multipart'){
          $this->denormalizerFromRequest($request);
       }else{
           $this->decorated->onKernelRequest($event);
       }
    }

    private function denormalizerFromRequest(Request $request):void
    {
    $attributes = RequestAttributesExtractor::extractAttributes($request);
    if (empty($attributes)){
        return;
    }
    $context = $this->contextBuilder->createFromRequest($request,false,$attributes);
    $populated = $request->attributes->get('data');

    if ($populated != null){
        $context['object_to_populate']= $populated;
    }
    $data = $request->request->all();

    $files = $request->files->all();
    //dd(array_merge($data, $files));
        //dd($files);
    $object = $this->denormalizable->denormalize(
        array_merge($data, $files),$attributes['resource_class'],null,$context
    );
   $request->attributes->set('data',$object);
    }

}