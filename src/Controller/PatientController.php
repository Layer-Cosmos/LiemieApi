<?php


namespace App\Controller;


use App\Core\Controller\Controller;
use App\Database\Database;

class PatientController extends Controller
{
    public function index()
    {
        $pdo = new Database("api");

        $res = $pdo->query("SELECT * FROM patient");

        echo json_encode($res);
    }
}