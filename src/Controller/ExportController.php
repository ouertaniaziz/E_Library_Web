<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/excel")
 */
class ExportController extends AbstractController
{
/**
 * @Route("/excel/export",  name="export")
 */
    public function export()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Users List');
    $sheet->getCell('A1')->setValue('User ID');
    $sheet->getCell('B1')->setValue('Nom');
    $sheet->getCell('C1')->setValue('Prénom');
    $sheet->getCell('D1')->setValue('Email');
    $sheet->getCell('D1')->setValue('Adresse');

    // Increase row cursor after header write
    $sheet->fromArray($this->getData(),null, 'A2', true);
    $writer = new Xlsx($spreadsheet);
    $writer->save('ss.xlsx');
    return $this->redirectToRoute('app_users_index');

}

    public function getData() :array
    {
        /**
         * @var $user Users[]
         */
        $list = [];
        $user = $this->getDoctrine()->getRepository(Users::class)->findAll();
        foreach ($user as $Users) {
            $list[] = [
                $Users->getIdUser(),
                $Users->getNomUser(),
                $Users->getPrenomUser(),
                $Users->getEmailUser(),
                $Users->getAdresse(),
            ];
        }
        return $list;
    }

}