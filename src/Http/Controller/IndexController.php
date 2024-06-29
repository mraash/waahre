<?php

namespace App\Http\Controller;

use App\Feature\ProductList\Raw\Exel\WarehouseExelRequestConverter;
use App\Feature\ProductList\Raw\Html\WarehouseHtmlRequest;
use App\Feature\ProductList\Raw\Html\WarehouseRequestHtmlConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    private const FORM_WAREHOUSE_REQUEST = 'warehouse-request-html';

    #[Route('/', name: 'page.index')]
    public function index(): Response
    {
        return $this->render('page/index/index.twig', [
            'controller_name' => 'IndexController',
            'form' => [
                'file' => self::FORM_WAREHOUSE_REQUEST,
            ],
        ]);
    }

    #[Route('/convert', name: 'action.convert', methods: ['POST'])]
    public function convert(Request $request): Response
    {
        /** @var UploadedFile */
        $file = $request->files->get(self::FORM_WAREHOUSE_REQUEST);

        $content = file_get_contents($file->getPathname());

        $warehouseHtmlRequest = new WarehouseHtmlRequest($content);
        $warehouseRequest = (new WarehouseRequestHtmlConverter())->decode($warehouseHtmlRequest);

        $warehouseExelRequest = (new WarehouseExelRequestConverter())->encode($warehouseRequest);

        $result = $warehouseExelRequest->getRawData();

        $filename = 'norakstit-' . time() . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");

        $result->save('php://output');

        return new Response();
    }
}
