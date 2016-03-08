<?php


namespace Test\MyBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Test\MyBundle\Entity\City;
use Test\MyBundle\Entity\Country;
use Test\MyBundle\Entity\State;
use Test\MyBundle\Entity\CityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CityType extends  AbstractType{

    protected $em;

    public function __construct($em){
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder,array$options){
        $builder->add('country', 'entity', array(
            'class' => 'TestMyBundle:Country',
            'empty_value'=>'-- Choose --',
            'choice_label' => 'country'
        ));
        $builder->add('Search','submit');

        $stateFormbuilder = function(FormInterface $form,$country_Id){
            $search = $form->get('Search');
            $form->remove('Search');
            $form->add('state','entity',array(
                'class'=>'TestMyBundle:State',
                'query_builder'=>function(EntityRepository $repository) use ($country_Id){
                    return $repository->createQueryBuilder('State')
                                        ->where('State.countryId= :countryId')
                                        ->setParameter('countryId',$country_Id)
                                        ->orderBy('State.state','ASC')
                                        ;
                }
            ));
        };
        $CityFormbuilder = function(FormInterface $form, $state_Id){
            $form->add('city','entity',array(
                'class'=>'TestMyBundle:City',
                'query_builder'=>function(EntityRepository $repository) use ($state_Id){
                    return $repository->createQueryBuilder('City')
                                      ->where('City.stateId= :stateId')
                                        ->setParameter('stateId',$state_Id)
                                        ->orderBy('City.city','ASC')
                                        ;
                }
            ));
        };
        $CityAreaFormBuilder = function(FormInterface $form, $city_Id){
            $form->add('cityArea','entity',array(
                'class'=>'TestMyBundle:CityArea',
                'query_builder'=>function(EntityRepository $repository) use ($city_Id){
                    return $repository->createQueryBuilder('CityArea')
                        ->where('CityArea.city= :cityId')
                        ->setParameter('cityId',$city_Id)
                        ->orderBy('CityArea.cityArea','ASC')
                        ;
                }
            ));
            $form->add('Search','submit');
        };

        //$CityFormbuilder, $CityAreaFormBuilder
        //$builder->add('Search', 'submit');
        // State

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use($stateFormbuilder) {
            $country = $event->getData();
            $country_id = null;
            if(null!== $country){
                $country_id = $country->getId();
            }
            $stateFormbuilder($event->getForm(),$country_id);
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT,function(FormEvent $event) use($stateFormbuilder){
            $data = $event->getData();
            $country_id = array_key_exists('id',$data) ? $data['id']:null;
            $stateFormbuilder($event->getForm(),$country_id);
        });
        // City
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use($CityFormbuilder) {
            $state = $event->getData();
            $stateId = null;
            if(null!==$state){
                $stateId = $state->getId();
            }
            $CityFormbuilder($event->getForm(),$stateId);
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT,function(FormEvent $event) use($CityFormbuilder){
            $data = $event->getData();
            $city_id = array_key_exists('id',$data) ? $data['id']:null;
            $CityFormbuilder($event->getForm(),$city_id);
        });
        // City Area
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use($CityAreaFormBuilder) {
            $cityArea = $event->getData();
            $cityAreaId = null;
            if(null!==$cityArea){
                $cityAreaId= $cityArea->getId();
            }
            $CityAreaFormBuilder($event->getForm(),$cityAreaId);
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT,function(FormEvent $event) use($CityAreaFormBuilder){
            $data = $event->getData();
            $cityArea_Id = array_key_exists('id',$data) ? $data['id']:null;
            $CityAreaFormBuilder($event->getForm(),$cityArea_Id);
        });
    }
    public function getName(){
        return 'cityarea';
    }
}