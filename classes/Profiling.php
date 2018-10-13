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
            self::$instance->mainChrono = new MesureItem('MainChrono');
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
                    $mesure->EndChrono();
                    $instance->results[] = $mesure;
                    unset($mesure);
                }
                $mesure = new MesureItem($name);
            }
            else
            {
                $instance->valeurs[] = new MesureItem($name);
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
                    $mesure->EndChrono();
                    $instance->results[] = $mesure;
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
                    $mesure->EndChrono();
                }
                $instance->results[] = $mesure;
                unset($mesure);
            }
            $instance->mainChrono->EndChrono();
        }
    }

    public static function DisplayResults($commented = false)
    {
        if ($commented) { $msg .= "/*"; }

        $msg .= "<h5>Start profiling</h5><ul>";
        $instance = self::getSingleton();
        foreach ($instance->results as $value)
        {
            $msg .= "<li>". $value->getElapsedTime() ."</li>";
        }
        $msg .= "</ul>";
        $msg .= "Total elapsed time : ". $instance->mainChrono->getElapsedTime();

        if ($commented) { $msg .= "*/"; }
        echo $msg;
    }
}
class MesureItem
{
    private $name;
    private $mesure;
    private static $count;

    public function __construct($name)
    {
        $this->name = $name;
        $this->mesure = new Mesure();
    }
    public function EndChrono()
    {
        $this->mesure->endChrono();
    }
    public function isFinished()
    {
        return $this->mesure->isFinished();
    }
    public function getElapsedTime()
    {
        return $this->name ." : ". $this->mesure->getElapsedTime();
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
    public function endChrono()
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