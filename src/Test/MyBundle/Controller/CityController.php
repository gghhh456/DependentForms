<?php

namespace Test\MyBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Count;
use Test\MyBundle\Entity\CityArea;
use Test\MyBundle\Form\CityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CityController extends  Controller{

    public function IndexAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        /**
         * Search for City Area Directly
         */
        $formOne = $this->get('form.factory')->createNamedBuilder('TextSearch')
            ->add('CityArea', 'text', array(
                'attr' => array(
                    'placeholder' => ' Type City Area here',
                ),
                'label' => false
            ))
            ->add('Search', 'submit', array(
                'attr' => array(
                    'class' => 'search'),
                'label' => false
            ))
            ->getForm();
        /**
         * Advance Search (DropDown)
         */
        $CityArea = new CityArea();

        $formTwo = $this->get('form.factory')->create(new CityType($em));

        if('POST' === $request->getMethod()) {
            //formOne
            if ($request->request->has('TextSearch')) {
                $formOne->handleRequest($request);
                if ($formOne->isSubmitted() && $formOne->isValid()) {
                    $formOneData = $request->request->get('TextSearch');
                    $cityArea = $formOneData['CityArea'];

                    return $this->render('TestMyBundle:Search:index.html.twig', array(
                        'formOne' => $formOne->createView(),
                        'formTwo' => $formTwo->createView(),
                        'cityArea' => $cityArea
                    ));
                }
            }
            if ($request->request->has('cityarea')) {
                $formTwo->handleRequest($request);

                if ($formTwo->isSubmitted() && $formTwo->isValid()) {
                    $formTwoData = $request->request->get('cityarea');
                    $country = $formTwoData['cityArea'];

                    echo $country;

                    return $this->render('TestMyBundle:Search:index.html.twig', array(
                        'formOne' => $formOne->createView(),
                        'formTwo' => $formTwo->createView(),

                    ));
                }

            }
        }
        return $this->render('TestMyBundle:Search:index.html.twig',array(
            'formOne'=> $formOne->createView(),
            'formTwo'=> $formTwo->createView(),
        ));
    }

    public function AjaxStateAction(Request $request){

        if (! $request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }
        $countryId = $request->request->get('countryId');
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('TestMyBundle:State')->GetStateName($countryId);
        $count = Count($data);
        return new JsonResponse(array(
            'data'=>$data,
            'count'=> $count
        ));
    }

    public function AjaxCityAction(Request $request){

        if (! $request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }
        $StateId = $request->request->get('state');
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('TestMyBundle:City')->GetCityName($StateId);
        $count = Count($data);
        return new JsonResponse(array(
            'data'=>$data,
            'count'=> $count
        ));
    }

    public function AjaxCityAreaAction(Request $request){

        if (! $request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }
        $cityId = $request->request->get('city');
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('TestMyBundle:CityArea')->GetCityAreaName($cityId);
        $count = Count($data);
        return new JsonResponse(array(
            'data'=>$data,
            'count'=> $count
        ));
    }
}