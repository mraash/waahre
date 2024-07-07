<?php

namespace App\Http\Controller;

use App\Domain\Feature\ProductList\Converter\WarehouseRequestToWriteOffConverter;
use App\Domain\Feature\ProductList\Raw\WarehouseRequest\ProductHtmlRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    private const FORM_WAREHOUSE_REQUEST = 'warehouse-request-html';

    public function __construct(
        private WarehouseRequestToWriteOffConverter $converter,
    ) {
    }

    #[Route('/', name: 'page.index')]
    public function index(): Response
    {
        return $this->render('page/index/index.twig', [
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

        $result = $this->converter->convertFully($content);

        $filename = 'norakstit-' . time() . '.xls';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");

        $result->save('php://output');

        return new Response();
    }
}
