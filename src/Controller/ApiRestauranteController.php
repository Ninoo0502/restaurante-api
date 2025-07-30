<?php

namespace App\Controller;

use App\Entity\Restaurante;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/restaurantes')]
class ApiRestauranteController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(RestauranteRepository $restauranteRepository): JsonResponse
    {
        $restaurantes = $restauranteRepository->findAll();
        $data = [];

        foreach ($restaurantes as $restaurante) {
            $data[] = [
                'id' => $restaurante->getId(),
                'nombre' => $restaurante->getNombre(),
                'direccion' => $restaurante->getDireccion(),
                'telefono' => $restaurante->getTelefono(),
            ];
        }

        return $this->json($data);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nombre']) || empty(trim($data['nombre']))) {
            return $this->json(['error' => 'El nombre es obligatorio.'], 400);
        }

        if (!isset($data['direccion']) || empty(trim($data['direccion']))) {
            return $this->json(['error' => 'La dirección es obligatoria.'], 400);
        }

        if (!isset($data['telefono']) || !preg_match('/^\d{4,15}$/', $data['telefono'])) {
            return $this->json(['error' => 'El teléfono es obligatorio y debe tener entre 4 y 15 dígitos.'], 400);
        }

        $restaurante = new Restaurante();
        $restaurante->setNombre($data['nombre']);
        $restaurante->setDireccion($data['direccion']);
        $restaurante->setTelefono($data['telefono']);

        $em->persist($restaurante);
        $em->flush();

        return $this->json(['message' => 'Restaurante creado', 'id' => $restaurante->getId()], 201);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Restaurante $restaurante): JsonResponse
    {
        return $this->json([
            'id' => $restaurante->getId(),
            'nombre' => $restaurante->getNombre(),
            'direccion' => $restaurante->getDireccion(),
            'telefono' => $restaurante->getTelefono(),
        ]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, Restaurante $restaurante, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre']) && empty(trim($data['nombre']))) {
            return $this->json(['error' => 'El nombre no puede estar vacío.'], 400);
        }

        if (isset($data['direccion']) && empty(trim($data['direccion']))) {
            return $this->json(['error' => 'La dirección no puede estar vacía.'], 400);
        }

        if (isset($data['telefono']) && !preg_match('/^\d{4,15}$/', $data['telefono'])) {
            return $this->json(['error' => 'El teléfono debe tener entre 4 y 15 dígitos.'], 400);
        }

        $restaurante->setNombre($data['nombre'] ?? $restaurante->getNombre());
        $restaurante->setDireccion($data['direccion'] ?? $restaurante->getDireccion());
        $restaurante->setTelefono($data['telefono'] ?? $restaurante->getTelefono());

        $em->flush();

        return $this->json(['message' => 'Restaurante actualizado']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Restaurante $restaurante, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($restaurante);
        $em->flush();

        return $this->json(['message' => 'Restaurante eliminado']);
    }
}
