<?php

class Profiling {
    
    private static $instance = null;
    private $mainChrono = null;
    private $valeurs = [];
    private $results = [];

    private function __construct() { }
    private static function getSingleton()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Profiling();
            self::$instance->mainChrono = new Mesure();
        }
        return self::$instance;
    }
    public static function StartChrono($name = null)
    {
        $instance = self::getSingleton();
        if ($name != null)
        {
            if (array_key_exists($name, $instance->valeurs))
            {
                $mesure = $instance->valeurs[$name]; 
                if (!$mesure->isFinished())
                {
                    $mesure->endChorno();
                    $instance->results[$name] = $mesure;
                    unset($mesure);
                }
                $mesure = new Mesure();
            }
            else
            {
                $instance->valeurs[$name] = new Mesure();
            }
        }
    }

    public static function EndChrono($name = null)
    {
        $instance = self::getSingleton();
        if ($name != null)
        {
            if (array_key_exists($name, $instance->valeurs))
            {
                $mesure = $instance->valeurs[$name]; 
                if (!$mesure->isFinished())
                {
                    $mesure->endChorno();
                    $instance->results[$name] = $mesure;
                    unset($mesure);
                }
            }
        }
        else
        {
            foreach ($instance->valeurs as $name => $mesure)
            {
                if(!$mesure->isFinished())
                {
                    $mesure->endChorno();
                }
                $instance->results[$name] = $mesure;
                unset($mesure);
            }
            $instance->mainChrono->endChorno();
        }
    }

    public static function DisplayResults()
    {
        $msg = "<h5>Start profiling</h5><ul>";
        $instance = self::getSingleton();
        foreach ($instance->results as $key => $value)
        {
            $msg .= "<li>". $key ." : ". $value->getElapsedTime() ."</li>";
        }
        $msg .= "</ul>";
        $msg .= "Total elapsed time : ". $instance->mainChrono->getElapsedTime();
        echo $msg;
    }
}

class Mesure
{
    private $startTime = null;
    private $endTime = null;
    public function __construct()
    {
        $this->startTime = microtime(true);
    }
    public function endChorno()
    {
        $this->endTime = microtime(true);
    }
    public function isFinished()
    {
        return ($this->startTime != null && $this->endTime != null);
    }
    public function getElapsedTime()
    {
        return $this->endTime - $this->startTime;
    }
}
?>