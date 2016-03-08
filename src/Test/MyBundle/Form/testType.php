<?php


namespace Mnv\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Mnv\CoreBundle\Entity\Orase;
use Mnv\CoreBundle\Entity\DateClienti;


class DateClientiType extends AbstractType
{

    private $idSocietate;

    function __construct($idSocietate) {
        $this->idSocietate = $idSocietate;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
            $event->stopPropagation();
        }, 900);


        $builder->add('suprafata_inchiriata','text',array('required' => false));
        $builder->add('suma_chirie','text',array('required' => false));
        $builder->add('suma_fixa_chirie','text',array('required' => false));
        $builder->add('curs_bnr','checkbox', array('required' => false));
        $builder->add('platitor_tva','checkbox', array('required' => false));
        $builder->add('fact_auto','checkbox', array('required' => false));
        $builder->add('nr_contract','text',array('required' => false));
        $builder->add('data_contract','date', array('required' => false, 'widget' => 'single_text', 'format'=>'dd/MM/yyyy'));
        $builder->add('act_aditional','text',array('required' => false));
        $builder->add('data_actaditional','date', array('required' => false, 'widget' => 'single_text', 'format'=>'dd/MM/yyyy'));
        $builder->add('strada_spatiu','text',array('required' => false));
        $builder->add('etaj_spatiu','text',array('required' => false));
        $builder->add('pozitie_spatiu','text',array('required' => false));
        $builder->add('achitare','text',array('required' => false));
        $builder->add('tip_fact_utilitati', 'choice', array(
            'choices' => array(
                'cumulata' => 'Cumulata',
                'unitara' => 'Unitara',
                'separata' => 'Separata'
            ),
            'required' => false,
            'expanded' => false,
            'multiple' => false,
            'invalid_message' => 'Valoarea aleasa nu este valida!',
            'empty_value' => false
        ));



        $builder->add('orase', 'entity', array(
            'class'       => 'MnvCoreBundle:Orase',
            'property'    => 'oras',
            'empty_value' => 'Selectati',
        ));


        $idSocietate = $this->idSocietate;


        $formModifier = function (FormInterface $form, Orase $orase = null) use ($idSocietate) {
            $positions = array();
            if (null !== $orase) {
                $positions = $orase;
            }
            $form->add('curs_valutar', 'entity', array(
                'class'       => 'MnvCoreBundle:CursValutar',
                'query_builder' => function(EntityRepository $er) use ($idSocietate,$positions) {
                    return $er->createQueryBuilder('c')
                        ->where('c.societati = :idSocietate AND c.orase = :oras')
                        ->setParameter('idSocietate', $idSocietate)
                        ->setParameter('oras', $positions)
                        ->orderBy('c.idCurs', 'ASC');
                },
                'empty_value' => 'Selectati',
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                //var_dump($data); exit;
                // so after var dumping i noticed the $data was null
                // i tried many solutions found online with no success
                // so the problem was the error i got when getOrase was called on a non
                // object, so i need it an object and here it is:

                if ($data !== null) { // chack to see if $data is not null
                    // now we can safely call getOrase() on event
                    $formModifier($event->getForm(), $data->getOrase());
                } else { // if it is null
                    $data = new DateClienti; // instantiate the class 
                    // (don't forget to import the class)
                    $formModifier($event->getForm(), $data->getOrase()); // no error now :)
                }



            }
        );

        $builder->get('orase')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $oras = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $oras);
            }
        );


    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mnv\CoreBundle\Entity\DateClienti',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'date_clienti';
    }
}