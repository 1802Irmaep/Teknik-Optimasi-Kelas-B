<?php

class Parameters{
    const FILE_NAME = 'produk.txt';
    const COLUMNS = ['item', 'price'];
    const POPULATION_SIZE = 22;
    const BUDGET = 300000;
    const STOPPING_VALUE = 10000;
    const CROSSOVER_RATE = 0.8;
}

class Catalogue{
    function createProductColumn($columns, $listOfRawProduct){
        foreach (array_keys($$listOfRawProduct) as $listOfRawProductKey){
            $listOfRawProduct[$columns[$listOfRawProductKey]] = $listOfRawProduct[$listOfRawProductKey];
            unset($listOfRawProduct[$listOfRawProductKey]);
        }
        return $listOfRawProduct;
    }
    function product($parameters){
        $collectionOfListProduct = [];

        $raw_data = file($parameters['file_name']);
        foreach ($raw_data as $listOfRawProduct){
            $collectionOfListProduct[] = $this->createProductColumn($parameters['columns'], explode(",", $listOfRawProduct));

        }
        return [
            'product' => $collectionOfListProduct,
            'gen_length' => count($collectionOfListProduct)
        ];
    
    }
}
class PopulationGenerator{
    function createIndividu($parameters){

    }
    function createPopulation($parameters)
    {
        $catalogue = new Catalogue;
        $lengthOfGen = $catalogue->product($parameters)['gen_length'];
        for ($i = 0; $i <= $parameters['population_size']; $i++)
        {
            $this->createIndividu($parameters);
            $ret[] = rand(0,1);
        }
        return $ret;
    }


    //function createPopulation($parameters)
    //{
     //   for ($i = 0; $i <= $parameters['population_size']; $i++)
     //   {
     //       $this->createIndividu($parameters);
      //      $ret[] = $this->createIndividu($parameters);
      //  }

      //  foreach ($ret as $key => $val)
       // {
       //     print_r($val);
        //    echo '<br>';

       // }
        
   // }
}

class Fitness
{
    function selectingItem(){
        $catalogue = new Catalogue;
    }
    function searchBestIndividu($fits, $maxItem, $numberIndividuHasMaxItem)
    {
        if ($numberIndividuHasMaxItem === 1){
            $index = array_search($maxItem, array_column($fits, 'numberOfSelectedItem'));
            print_r($fits[$index]);
        }
        else
        {
            foreach ($fits as $key => $val)
            {
                if($val['numberOfSelectedItem'] === $maxItem)
                {
                    echo $key.' '.$val['fitnessValue'].'<br>';
                    $ret[]= [
                        'individuKey' => $key,
                        'fitnessValue' => $val['fitnessValue']
                    ];
                }
            }
            if (count(array_unique(array_column($ret, 'fitnessValue'))) === 1){
                $index = rand (0, count($ret) -1);

            }else{
                $max = max(array_column($ret, 'fitnessValue'));
                $index = array_search($max, array_column($ret, 'fitnessValue'));
            }

           // return $ret[$index];
           print_r($ret[$index]);
        }
    }

    function calculateFitnessValue($individu){
        return array_sum(array_column($this->selectingItem($individu),'selectedPrice'));
    }

    function countSelectedItem($individu){
        return count($this->selectingItem($individu));
    }
    

    function isFound($fits){
        $countedMaxItem = array_count_values(array_column($fits, 'numberOfSelectedItem'));
        print_r($countedMaxItem);
        echo '<br>';
        $maxItem = max(array_keys($countedMaxItem));
        echo $maxItem;
        echo '<br>';
        echo $countedMaxItem[$maxItem];
        $numberIndividuHasMaxItem = $countedMaxItem[$maxItem];

        $bestfitnessValue = $this->searchBestIndividu($fits, $maxItem, $numberIndividuHasMaxItem)[' fitnessvalue'];
        print_r($bestfitnessValue);
        echo '<br>Best fitness value : '.$bestfitnessValue['fitnessValue'];


        $residual = Parameters::BUDGET - $bestfitnessValue;
        echo ' Residual: '.$residual;

        if ($residual <= Parameters::STOPPING_VALUE && $residual > 0){
            return TRUE;
        }

    }


    function isFit($fitnessValue){
        if ($fitnessValue <= Parameter::BUDGET){
            return TRUE;
        }
    }

    function fitnessEvaluation($population){
        $catalogue = new Catalogue;
        foreach ($population as $listOfRawIndividutKey => $listOfIndividu){
            echo 'Individu-'.$listOfIndividuKey.'<br>';
            foreach ($listOfIndividu as $individuKey => $binaryGen){
                echo $binaryGen.'$nbsp;$nbsp;';
                print_r($catalogue->product()[$individuKey]);
                echo '<br>';
            }
            $fitnessValue = $this->calculateFitnessValue($listOfIndividu);
            $numberOfSelectedItem = $this->countSelectedItem($listOfIndividu);
            echo 'Max. Item: '. $numberOfSelectedItem;
            echo ' Fitness value: '.$fitnessValue;
            if ($this->isFit($fitnessValue)){
                echo ' (Fit)';
                $fits[] =[
                    'selectedIndividuKey' => $listOfIndividuKey,
                    'numberOfSelectedItem' => $numberOfSelectedItem,
                    'fitnessValue' => $fitnessValue
                ];
                print_r($fits);
            }else{
                echo ' (Not Fit)';
            }
            echo '<p>';
        }
        //function calculateFitnessValue($individu){

        //}
        if($this->isFound($fits)){
            echo ' Found';

        }else{
            echo' >> Next generation';
        }
    }
}
class crossover{
    public $population;
    //function__construct($population){
     //   $this->populations = $populations;
   // }
    function randomZeroToOne(){
        return (float) rand() / (float) getrandmax();

    }
    function generatorCrossover(){
        for ($i = 0; $i <= Parameters::POPULATION_SIZE-1; $i++){
            $randomZeroToOne = $this->randomZeroToOne();
            if($randomZeroToOne < Parameters::CROSOVER_RATE){
                $pare[$i] = $randomZeroToOne;
            }
        }
        echo '<br>';
        print_r($parents);
    }
    function crossover(){

    }
}




function randomZeroToOne(){
    return (float) rand() / (float) getrandmax();

}
function generatorCrossover(){
    for($i=0; $i<=Parameters::POPULATION_SIZE-1; $i++){
        $randomZeroToOne = $this->randomZeroToOne();
        if ($randomZeroToOne < Parameters::CROSOVER_RATE){
            $parents[$i] = $randomZeroToOne;
        }
    }
    foreach (array_keys($parents) as $key){
        foreach(array_keys($parents) as $subkey){
            if ($key !== $subkey){
                //$ret[] [$key, $subkey];
            }
        }
        array_shift($parents);
    }
    //print_r($ret);
    return $ret;
}

function offspring($parent1, $parent2, $cutPointIndex, $offspring)
{
    $lengthOfGen = new Individu;
    if ($offspring === 1){
        for ($i = 0; $i <= $lengthOfGen->countNumberOfGen()-1; $i++){
            if ($i <= $cutPointIndex)
            $ret[] = $parent1[$i];
        }
        if ($i > $cutPointIndex){
            $ret[] = $parent2[$i];
        }
    }
    //if ($offspring === 2){
     //   for ($i = 0; $i <= $lengthOfGen-> countNumberOfGen() - 1; $i++){
     //       if ($i <= $cutPointIndex)
     //       $ret[] = $parent2[$i];
    //    }
     //   if($i > $cutPointIndex){
     //       $ret[] = $parent1[$i];
     //   }
    //}
    return $ret;
}
function cutPointRandom()
{
    $lengthOfGen = new Individu;
    return rand (0, $lengthOfGen->countNumberOfGen() - 1);
}
    
function crossover(){
    $lengthOfGen = new Individu;
    return rand(0, $lengthOfGen->countNumberOfGen()-1);
}


function crossover(){
    $cutPointIndex = $this->cutPointRandom();
    echo $cutPointIndex;
    foreach ($this->generatorCrossover() as $listOfCrossover){
        $parent1 = $this->populations[$listOfCrossover[0]];
        $parent2 = $this->populations[$listOfCrossover[1]];
        echo '<p></p>';
        echo 'Parents :<br>';
        foreach ($parent1 as $gen){
            echo $gen;
        }
        echo ' >< ';
        foreach ($parent2 as $gen){
            echo $gen;
        }
        echo '<br>'
        //print_r($listOfCrossover);
       //echo'<br>';
       //s echo 'Offspring<br>';
        $offspring1 = $this->offspring($parent1, $parent2, $cutPointIndex, 1);
        $offspring2 = $this->offspring($parent2, $parent2, $cutPointIndex, 2);
        print_r($offspring1);
        foreach ($offspring1 as $gen) {
          echo $gen;
        }
        echo '<br>';
        print_r($offspring2);
        echo '><';
        foreach($offspring2 as $gen){
          echo $gen;
        }
    }
    $this->generatorCrossover()
}



$initalPopulation = new Population ;
$population = $initalPopulation->createRandomPopulation();

$fitness = new Population ;
$fitness->fitnessEvaluation($population);


$crossover = new Crossover($population);
$crossover->crossover();


//$individu = new individu;
//print_r($individu->createRandomIndividu());

 
$parameters[
    'file_name' => 'produk.txt',
   // 'columns' => ['item', 'price'],
    'population_size' => 30
];
$katalog = new Catalogue;
print_r($katalog->product($parameters));

$initalPopulation = new PopulationGenerator;
$initalPopulation->createPopulation($parameters);

?>