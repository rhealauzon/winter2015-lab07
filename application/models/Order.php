<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Order extends CI_Model {

    protected $xml = null;
    public $customer;
    public $orderType;
    public $orderInstructions = "";
    public $burgers = array();
    public $orderTotal = 0.00;
        
    // Constructor
    public function __construct($filename = null) 
    {
        parent::__construct();
        if($filename == null)
        {
            return;
        }
        
        //load the menu model
        $this->load->model('menu');
        
        $this->xml = simplexml_load_file(DATAPATH . $filename);
        
        //assign customer to be the value from the order
        $this->customer = (string) $this->xml->customer;
        $this->orderType = (string) $this->xml['type'];
        
        //check for special instructions for the order
        if (isset($this->xml->special))
        {
            $this->orderInstructions = $this->xml->special;
        }
        
        $burgerCount = 0;
        foreach ($this->xml->burger as $burger) 
        {
            $newBurger = array (
                'patty' => $burger->patty['type']
            );
                     
            $burgerCount++;
            $newBurger['burgerNum'] = $burgerCount;
            
            //set the cheeses as specified
            $cheeses = "";
            
            //check if there is top cheese
            if (isset($burger->cheeses['top']))
            {               
                $cheeses .= $burger->cheeses['top'] . ' (top)   ';
            }
            
            //check if there is bottom cheese
            if (isset($burger->cheeses['bottom']))
            {               
                $cheeses .= $burger->cheeses['bottom'] . ' (bottom)';
            }
            
            //add the cheese to the burger array
            $newBurger['cheese'] = $cheeses;
            
            
            $toppings = "";
            //check if there are any 
            if (isset($burger->topping))
            {
                foreach ($burger->topping as $topping)
                {
                    $toppings .= $topping['type'] . ', ';
                }
            }
            else
            {
                $toppings .= "none";
            }
            //add the toppings to the burger           
            $newBurger['toppings'] = $toppings;
            
            $sauces = "";
            //check if there are any toppings
            if (isset($burger->sauce))
            {
                foreach ($burger->sauce as $sauce)
                {
                    $sauces .= $sauce['type'] . ', ';
                }
            }
            else
            {
                $sauces .= "none";
            }
            //add the sauce to the burger
            $newBurger['sauces'] = $sauces;
            
            //add any special instructions
            if (isset($burger->instructions))
            {
                $newBurger['instructions'] = $burger->instructions;
            }
            else
            {
                $newBurger['instructions'] = "";
            }
            
            $burgerCost = $this->getBurgerCost($burger);            
            $newBurger['burgerCost'] = $burgerCost;
            
            $this->orderTotal += $burgerCost;
            
            //add the final burger to the array
            $this->burgers[] = $newBurger;
         }
         
    }
    
    private function getBurgerCost($burger)
    {
        $burgerTotal = 0.00;
                
        //add the patty price to the total
        $burgerTotal += $this->menu->getPatty((string) $burger->patty['type'])->price;
        
        //add the cheeses price to the total
        if (isset($burger->cheeses['top']))
        {               
            $burgerTotal += $this->menu->getCheese((string) $burger->cheeses['top'])->price;
        }

        //check if there is bottom cheese
        if (isset($burger->cheeses['bottom']))
        {               
            $burgerTotal += $this->menu->getCheese((string) $burger->cheeses['bottom'])->price;
        }
        
        //Add the toppings
        foreach ($burger->topping as $topping)
        { 
            $burgerTotal += $this->menu->getTopping((string) $burger->topping['type'])->price;            
        }
        
        //Add the sauce
        foreach ($burger->sauce as $sauce)
        { 
            $burgerTotal += $this->menu->getSauce((string) $burger->sauce['type'])->price;            
        }
        
        return $burgerTotal;
        
    }

}
