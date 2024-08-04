<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Feature\ProductDocumentConverter\WarehouseRequestToWriteOffConverter;
use App\Domain\Feature\ProductDocument\BuffetProductRequest\BuffetProductRequest;
use App\Domain\Feature\ProductDocument\StationaryProductRequest\StationaryProductRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    private const FORM_STATIONARY_REQUEST = 'warehouse-request-html';
    private const FORM_BUFFET_REQUEST = 'warehouse-request-xml';

    public function __construct(
        private WarehouseRequestToWriteOffConverter $converter,
    ) {
    }

    #[Route('/', name: 'page.index')]
    public function index(): Response
    {
        return $this->render('page/index/index.twig', [
            'form' => [
                'stationary' => [
                    'file' => self::FORM_STATIONARY_REQUEST,
                ],
                'buffet' => [
                    'file' => self::FORM_BUFFET_REQUEST,
                ],
            ],
        ]);
    }

    #[Route('/convert-stationary', name: 'action.convert.stationary', methods: ['POST'])]
    public function convertStationary(Request $request): Response
    {
        /** @var UploadedFile */
        $file = $request->files->get(self::FORM_STATIONARY_REQUEST);

        $stationaryRequest = StationaryProductRequest::fromFile($file->getPathname());

        $result = $this->converter->convert($stationaryRequest)->getRawData();

        $filename = 'norakstit-' . time() . '.xls';

        // TODO: Wrap this in Symfony
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");

        $result->save('php://output');

        return new Response();
    }

    #[Route('/convert-buffet', name: 'action.convert.buffet', methods: ['POST'])]
    public function convertBuffet(Request $request): Response
    {
        /** @var UploadedFile */
        $file = $request->files->get(self::FORM_BUFFET_REQUEST);

        $buffetRequest = BuffetProductRequest::fromFile($file->getPathname());

        $result = $this->converter->convert($buffetRequest)->getRawData();

        $filename = 'norakstit-' . time() . '.xls';

        // TODO: Wrap this in Symfony
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");

        $result->save('php://output');

        return new Response();
    }
}
