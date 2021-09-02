<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GroceryCrud\Core\GroceryCrud;

class AdminController extends Controller
{

    /**
     * Grocery CRUD Example
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function customers()
    {
        $database = $this->_getDatabaseConnection();
        $config = config('grocerycrud');

        $crud = new GroceryCrud($config, $database);

        $crud->setTable('nav_invoice_out');
        $crud->setSubject('Customer', 'Customers');
//        $crud->displayAs('name', 'Név');
//        $crud->columns(['id','name']);
//        $crud->fields(['id']);
//
//        $crud->setActionButton('Alkatrészek', 'fa fa-asterisk', function ($row) {
//            return '/distributors/contents/';
//        }, false);

        $crud->setSubject('','Számlák');



        $output = $crud->render();


        if ($output->isJSONResponse) {
            return response($output->output, 200)
                ->header('Content-Type', 'application/json')
                ->header('charset', 'utf-8');
        }

        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $output = $output->output;

        return view('default_template', [
            'output' => $output,
            'css_files' => $css_files,
            'js_files' => $js_files
        ]);
    }

    private function _getDatabaseConnection() {

        return [
            'adapter' => [
                'driver' => 'Pdo_Mysql',
                'database' => env('DB_DATABASE'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'charset' => 'utf8'
            ]
        ];
    }

}
