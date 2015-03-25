<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    protected $xml = null;
    protected $patties = array();
    protected $cheeses = array();
    protected $toppings = array();
    protected $sauces = array();

    // Constructor
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');

        // build a full list of patties
        foreach ($this->$xml->patties->patty as $patty) 
        {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $patties[$record->code] = $record;
        }
        
        // build a full list of patties
        foreach ($this->$xml->patties->patty as $patty) 
        {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $patties[$record->code] = $record;
        }
    }


    // retrieve a patty record, perhaps for pricing
    function getPatty($code) 
    {
        if (isset($this->patties[$code]))
            return $this->patties[$code];
        else
            return null;
    }

}
