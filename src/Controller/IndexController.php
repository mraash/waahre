<?php

namespace App\Controller;

use App\WarehouseRequest\Raw\Exel\WarehouseExelRequestConverter;
use App\WarehouseRequest\Raw\Html\WarehouseHtmlRequest;
use App\WarehouseRequest\Raw\Html\WarehouseRequestHtmlConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'page.index')]
    public function index(): Response
    {
        return $this->render('page/index/index.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/convert', name: 'action.convert', methods: ['POST'])]
    public function convert(Request $request): Response
    {
        // $file = '/var/www/html/.ignore/Piep-pr-03-06.html';

        /** @var UploadedFile */
        $file = $request->files->get('warehose-request');

        $content = file_get_contents($file->getPathname());

        $warehouseHtmlRequest = new WarehouseHtmlRequest($content);
        $warehouseRequest = (new WarehouseRequestHtmlConverter())->decode($warehouseHtmlRequest);

        $warehouseExelRequest = (new WarehouseExelRequestConverter())->encode($warehouseRequest);

        $result = $warehouseExelRequest->getRawData();

        // $result->save('/var/www/html/.ignore/test.xls');

        $filename = 'norakstit-' . time() . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");

        $result->save('php://output');

        return new Response();
    }
}
