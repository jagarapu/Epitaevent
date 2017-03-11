<?php

namespace Events\Bundle\EventsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Events\Bundle\EventsBundle\Entity\User;
use Events\Bundle\EventsBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Events\Bundle\EventsBundle\Entity\Subscribed;
use Events\Bundle\EventsBundle\Form\Type\EventoneType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {

       return new RedirectResponse($this->generateUrl('closepage'));
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('securedhome'));
        }
        return array();
    }

    /**
     * @Route("/closepage",name="closepage")
     * @Template()
     */
    public function closeAction() {

        return array();
    }

    /**
     * @Route("/register",name="register")
     * @Template()
     */
    public function registerAction(Request $request) {

        return new RedirectResponse($this->generateUrl('closepage'));

        $em = $this->getDoctrine()->getManager();
        //Check to see if the user has already logged in
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('securedhome'));
        }

        $user = new User();

        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            //Do the needful
            $date = new \DateTime();
            $user->setCreatedon($date);
            $user->setEnabled(TRUE);
            $em->persist($user);
            $em->flush();
            $this->authenticateUser($user);
            $route = 'securedhome';
            $url = $this->generateUrl($route);
            return $this->redirect($url);
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/secured/home",name="securedhome")
     * @Template()
     */
    public function homeAction(Request $request) {

        return new RedirectResponse($this->generateUrl('closepage'));

        $em = $this->getDoctrine()->getManager();

        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('events_events_default_index'));
        }
        $user = $em->getRepository('EventsEventsBundle:User')->find($this->get('security.context')->getToken()->getUser()->getId());

        if (!is_object($user) || !$user instanceof User) {
            throw new \Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException('This user does not have access to this section.');
        }

        return array();
    }

    /**
     * @Route("/secured/eventone",name="eventone")
     * @Template()
     */
    public function eventoneAction(Request $request) {

        $exists = false;

        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('events_events_default_index'));
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('EventsEventsBundle:User')->find($this->get('security.context')->getToken()->getUser()->getId());

        if (!is_object($user) || !$user instanceof User) {
            throw new \Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException('This user does not have access to this section.');
        }

        $subrecord = $em->getRepository('EventsEventsBundle:Subscribed')->findOneBy(array('user' => $user->getId()));

        $event1 = $event2 = $event3 = '';
        if (!empty($subrecord)) {
            $exists = true;
            if ($subrecord->getEventtype1() != null || $subrecord->getEventtype1() != '') {
                $event1 = $subrecord->getEventtype1()->getId();
            }
            if (($subrecord->getEventtype2() != null || $subrecord->getEventtype2() != '')) {
                $event2 = $subrecord->getEventtype2()->getId();
            }
            if (($subrecord->getEventtype3() != null || $subrecord->getEventtype3() != '')) {
                $event3 = $subrecord->getEventtype3()->getId();
            }
        }

        $subscribed = new Subscribed();
        $form = $this->createForm(new EventoneType($subrecord), $subscribed);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if (($subscribed->getEventtype1() == null && $subscribed->getEventtype2() == null && $subscribed->getEventtype3() == null )
                    || ($subscribed->getEventtype1() != null && $subscribed->getEventtype2() != null && $subscribed->getEventtype3() != null )) {
                //User did not choose both the events
                $this->container->get('session')->getFlashBag()->add('error', 'Oh oh! It is mandatory to choose to attend TWO events only for the day');
                return array('form' => $form->createView());
            }
            if (   ($subscribed->getEventtype1() == null && $subscribed->getEventtype2() == null) || 
                    ($subscribed->getEventtype3() == null && $subscribed->getEventtype1() == null) || 
                    ($subscribed->getEventtype2() == null && $subscribed->getEventtype3() == null) )
                     {
                //User did not choose two events
                $this->container->get('session')->getFlashBag()->add('error', 'You must choose to attend TWO events for the day');                
                return array('form' => $form->createView());
            }
            
            $maxconferences1 = $this->container->getParameter('max_conferences1');
            $maxconferences2 = $this->container->getParameter('max_conferences2');
            $maxconferences3 = $this->container->getParameter('max_conferences3');
            //Now check for the participants limit
            $qb1 = $em->createQueryBuilder();
            $qb1->select('count(subscribed.id)');
            $qb1->from('EventsEventsBundle:Subscribed', 'subscribed');
            $qb1->where('subscribed.eventtype1 = :bar');
            $qb1->setParameter('bar', $subscribed->getEventtype1());

            $total1 = $qb1->getQuery()->getSingleScalarResult();

            if ($exists) {
                //Do count check only if event is different one for already registered users
                if ($event1 != $subscribed->getEventtype1()) {
                    if ($total1 > $maxconferences1 || $total1 == $maxconferences1) {
                        $this->container->get('session')->getFlashBag()->add('error', 'The registrations are full for the Event 1. Please choose another event for same time slot');
                        return array('form' => $form->createView());
                    }
                }
            } else {
                if ($total1 > $maxconferences1 || $total1 == $maxconferences1) {
                    $this->container->get('session')->getFlashBag()->add('error', 'The registrations are full for the Event 1. Please choose another event for same time slot');
                    return array('form' => $form->createView());
                }
            }

            $qb2 = $em->createQueryBuilder();
            $qb2->select('count(subscribed.id)');
            $qb2->from('EventsEventsBundle:Subscribed', 'subscribed');
            $qb2->where('subscribed.eventtype2 = :bar');
            $qb2->setParameter('bar', $subscribed->getEventtype2());

            $total2 = $qb2->getQuery()->getSingleScalarResult();

            if ($exists) {
                //Do count check only if event is different one for already registered users
                if ($event2 != $subscribed->getEventtype2()) {
                    if ($total2 > $maxconferences2 || $total2 == $maxconferences2) {
                        $this->container->get('session')->getFlashBag()->add('error', 'The registrations are full for the Event 2. Please choose another event for same time slot');
                        return array('form' => $form->createView());
                    }
                }
            } else {
                if ($total2 > $maxconferences2 || $total2 == $maxconferences2) {
                    $this->container->get('session')->getFlashBag()->add('error', 'The registrations are full for the Event 2. Please choose another event for same time slot');
                    return array('form' => $form->createView());
                }
            }

            $qb3 = $em->createQueryBuilder();
            $qb3->select('count(subscribed.id)');
            $qb3->from('EventsEventsBundle:Subscribed', 'subscribed');
            $qb3->where('subscribed.eventtype3 = :bar');
            $qb3->setParameter('bar', $subscribed->getEventtype3());

            $total3 = $qb3->getQuery()->getSingleScalarResult();

            if ($exists) {
                //Do count check only if event is different one for already registered users
                if ($event3 != $subscribed->getEventtype3()) {
                    if ($total3 > $maxconferences3 || $total3 == $maxconferences3) {
                        $this->container->get('session')->getFlashBag()->add('error', 'The registrations are full for the Event 3. Please choose another event for same time slot');
                        return array('form' => $form->createView());
                    }
                }
            } else {
                if ($total3 > $maxconferences3 || $total3 == $maxconferences3) {
                    $this->container->get('session')->getFlashBag()->add('error', 'The registrations are full for the Event 3. Please choose another event for same time slot');
                    return array('form' => $form->createView());
                }
            }
        }

        if ($form->isValid()) {

            $sub = $em->getRepository('EventsEventsBundle:Subscribed')->findOneBy(array('user' => $user->getId()));
            $eventtype1 = $em->getRepository('EventsEventsBundle:Eventtype')->findOneBy(array('id' => $subscribed->getEventtype1()));
            $eventtype2 = $em->getRepository('EventsEventsBundle:Eventtype')->findOneBy(array('id' => $subscribed->getEventtype2()));
            $eventtype3 = $em->getRepository('EventsEventsBundle:Eventtype')->findOneBy(array('id' => $subscribed->getEventtype3()));

            if (empty($sub)) {
                $subscribed->setUser($user);
                $subscribed->setEventtype1($eventtype1);
                $subscribed->setEventtype2($eventtype2);
                $subscribed->setEventtype3($eventtype3);
                $em->persist($subscribed);
                $copy = $subscribed;
            } else {
                $sub->setEventtype1($eventtype1);
                $sub->setEventtype2($eventtype2);
                $sub->setEventtype3($eventtype3);
                $em->persist($sub);
                $copy = $sub;
            }
            $em->flush();
            $route = 'securedhome';
            $url = $this->generateUrl($route);
            $this->container->get('session')->getFlashBag()->add('success', 'We have your registrations for the events on Thursday, 16th March 2017. Thank you!');
            $message = \Swift_Message::newInstance()
                    ->setSubject('EPITA International - Your Registrations for Thursday, 16th March 2017')
                    ->setFrom('epitaevents2017@gmail.com')
                    ->setTo($user->getEmailCanonical())
                    ->setContentType("text/html")
                    ->setBody(
                    $this->renderView('EventsEventsBundle:Default:thursdaymail.html.twig', array('row' => $copy)
            ));
            $this->get('mailer')->send($message);
            return $this->redirect($url);
        }

        return array('form' => $form->createView());
    }

    /**
     * Authenticate the user
     * 
     * @param FOS\UserBundle\Model\UserInterface
     */
    protected function authenticateUser(User $user) {
        try {
            $this->container->get('security.user_checker')->checkPostAuth($user);
        } catch (AccountStatusException $e) {
            // Don't authenticate locked, disabled or expired users
            return;
        }

        $providerKey = $this->container->getParameter('fos_user.firewall_name');
        $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->container->get('security.context')->setToken($token);
    }
    /**
     *
     * @Route("/export/thursday",name="exportthu")
     *      
     */
    public function exportthuAction() {
        $format = 'xls';
        $filename = sprintf('export_students_prep1_thursday.%s', $format);
        $data = array();
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery('SELECT s FROM Events\Bundle\EventsBundle\Entity\Subscribed s');
        $data = $query->getResult();
        $content = $this->renderView('EventsEventsBundle:Default:thursday.html.twig', array('data' => $data));
        $response = new Response($content);
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);
        return $response;
    }

}
