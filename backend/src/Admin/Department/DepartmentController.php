<?php

namespace App\Admin\Department;

use App\Admin\Shared\PaginationRequest;
use App\Entity\Department;
use App\Form\DepartmentFormType;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class DepartmentController extends AbstractController
{
    #[Route('/department', name: 'app_department_list', methods: ['GET'])]
    public function index(Request $request, #[MapQueryString] PaginationRequest $paginationRequest, DepartmentRepository $departmentRepository): Response
    {
        $paginator = $departmentRepository->getPaginatedDepartments($paginationRequest);
        $total = $paginator->count();

        return $this->render('admin/department/index.html.twig', [
            'departments' => $paginator,
            'total' => $total,
            'limit' => $paginationRequest->limit,
            'page' => $paginationRequest->page,
            'pageCount' => (int) max(1, ceil($total / $paginationRequest->limit)),
            'routeName' => 'app_department_list',
            'routeParams' => $request->query->all(),
        ]);
    }

    #[Route('/department/new', name: 'app_department_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $department = new Department();
        $form = $this->createForm(DepartmentFormType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($department);
            $entityManager->flush();

            return $this->redirectToRoute('app_department_show', ['id' => $department->getId()]);
        }

        return $this->render('admin/department/new.html.twig', [
            'department' => $department,
            'form' => $form,
        ]);
    }

    #[Route('/department/{id:department}', name: 'app_department_show', methods: ['GET'])]
    public function show(Department $department): Response
    {
        return $this->render('admin/department/show.html.twig', [
            'department' => $department,
        ]);
    }

    #[Route('/department/{id:department}/edit', name: 'app_department_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Department $department, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepartmentFormType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($department);
            $entityManager->flush();

            return $this->redirectToRoute('app_department_show', ['id' => $department->getId()]);
        }

        return $this->render('admin/department/edit.html.twig', [
            'department' => $department,
            'form' => $form,
        ]);
    }
}
