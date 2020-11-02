<?php
/**
 * Created by PhpStorm.
 * User: ELLIGY
 * Date: 27/02/2019
 * Time: 18:06
 */

namespace App\Controller;

use App\Form\OrganizationType;
use App\Service\AppParams;
use App\Service\Functions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrganizationController extends Controller
{
    protected $em;
    private $appParams;
    private $functions;

    public function __construct(
        EntityManagerInterface $entityManager,
        AppParams $appParams
    )
    {
        $this->em = $entityManager;
        $this->appParams = $appParams;

    }

    /**
     * @Route("/", name="list")
     */
    public function list(Request $request)
    {
        $appParams = $this->appParams->getAllParams();

        return $this->render('Organisation/list.html.twig', [
            "appParams" => $appParams
        ]);
    }

    /**
     * @Route("/post_edit/{name}", defaults={"name" = null}, name="post_edit")
     */
    public function postEdit(Request $request, $name = null)
    {
        if ($request->isXmlHttpRequest()) {
            $organization = $request->request->get("organization");
            $organization['users'] = json_decode($request->request->get("users"),true);
            $this->appParams->setParamByName($organization['name'],$organization);
            return new JsonResponse([ 'status' => 200 ]);
        }
        $organization = $this->appParams->getParamByName($name);
        $organizationForm = $this->createForm(OrganizationType::class, null,[
            'organization' => $organization
        ]);
        $organizationForm->handleRequest($request);

        return $this->render('Organisation/post_edit.html.twig', [
            'organization' => $organization,
            'organizationForm' => $organizationForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{name}", name="delete")
     */
    public function delete(Request $request, $name)
    {
        $this->appParams->deleteParam($name);
        return $this->redirectToRoute('list');
    }
}
