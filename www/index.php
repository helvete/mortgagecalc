<?php

namespace helvete\MortgageCalc;

class index {

    public function run(): void {
        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
             $this->generateForm();
             return;
        case 'POST':
             $this->submitForm();
             return;
        default:
            echo '{"result": "not implemented, bitch!"}';
            exit();
        }
    }

    private function generateForm(): void {
        include(__DIR__ . '/tpl.php');
    }

    private function submitForm(): void {
        $eng = new Engine();
        echo "<pre>";
        var_dump($_POST, $eng);
        exit();
        # TODO: validation
        # TODO: print data
    }
}
#phpinfo();
require_once(__DIR__ . '/Engine.php');
(new index())->run();
