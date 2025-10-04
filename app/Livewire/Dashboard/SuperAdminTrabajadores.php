<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class SuperAdminTrabajadores extends Component
{

    public $currentStep='list';
    public $nombre='';
    public $apellido='';
    public $cedula='';
    public $birthDay='';
    public $area='';
    public $telefono='';

    public $workAreas=[
        "1" => 'Cocina',
        "2" => 'Uity',
        "3" => 'Chofer'

    ];

     public function backTable($param){
        $this->currentStep=$param;
    }
    public function changeTab(){

        if($this->currentStep==='list'){
        $this->currentStep='create';
        }else{
            $this->backTable('list');
        }
    }

    public function submitForm (){
        dd($this->area);
    }
   

    public function render()
    {
        return view('livewire.dashboard.super-admin-trabajadores')->layout('components.layouts.rbac');
    }
}
