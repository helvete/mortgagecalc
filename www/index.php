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
        $inp = new CalculationInput($_POST);
        if ($inp->hasErrors()) {
            # TODO: validation
            var_dump($inp->getErrors());
            exit();
        }
        $result = Engine::calculate($inp);
        include(__DIR__ . '/result_tpl.php');
    }
}
require_once(__DIR__ . '/Engine.php');
(new index())->run();
