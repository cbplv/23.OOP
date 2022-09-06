<?php
interface specialActions {
    public function specialaction(int $v);
    public function signal();
}

interface ladle {
    public function rotateLadle(int $degree);
}
interface carInterface {
    public function wipe();
}

abstract class vehicles implements specialActions{
    public $type = "vehicle";
    protected $v = 34;
    protected $distance = 0;

    public function forward(int $km) {
        $this->distance +=  $km;
        echo "Vehicle moved forward ->: " .$km.", total distance: ".$this->distance.".\n";
    }
    public function backward(int $km) {
        $this->distance -=  $km;
        if ($this->distance < 0) $this->distance = 0;
        
        echo "Vehicle moved backward <-: " .$km.", total distance: ".$this->distance.".\n";
    }
    public function signal(){
        echo '!!!beep-beep!!!'."\n";
    }  
}

class cars extends vehicles{
    public $extra = [];
    public function __construct($acc = true, $ac = true, $rg = false){
        $this->extra["acc"] = $acc;
        $this->extra["ac"] = $ac;
        $this->extra["rg"] = $rg;

        var_dump($this->extra);
    }

    public function __get($key){
        if(array_key_exists($key, $this->extra)){
            return $this->extra[$key];
        } else{
            return null;
        }
    }
    public function __set($key, $value){
        $this->extra[$key]= $value;
    }
    public function specialaction(int $v){
        echo "nitro exhausted"."\n";
    }
}
class specialVehicle extends vehicles{
    protected $v = '45';
    public function specialaction(int $v){
        echo "ladle rotated to ".$v." degree."."\n";
    }

}
class tank extends vehicles{
    public function specialaction(int $v){
        echo  'fired: '.$v.' times\n';
    }
}
    class vehicleController implements carInterface{
        protected $isWipeOn = true;
        public function action(vehicles $vehicle){
            $vehicle->forward(10);
            $vehicle->backward(26);
            $vehicle->specialaction(35);
        }
        public function wipe(){
            if ($this->isWipeOn) {
                $this->isWipeOn = false;
                echo "wipers off"."\n";
            }else{
                $this->isWipeOn = true;
                echo "wipers on"."\n";
            }
        }
    }

$car = new cars();
$specialVehicle = new specialVehicle();

$vehiclecontroller = new vehicleController();

$vehiclecontroller->action($car); //Basic actions call with special action
$car->signal(); //direct call for Signal
if (isset($car->extra["acc"])) {echo "AirCondition Exists"."\n"; }else {echo "No AirCondition"."\n";}; //Check What car consists of
$vehiclecontroller->wipe(); // Wipers On
$vehiclecontroller->wipe(); //Wipers off

$vehiclecontroller->action($specialVehicle); //Actions for anohter special vehicle