<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
        
        //load the directory helper
        $this->load->helper('directory');
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
	// Build a list of orders
        $map = directory_map('./data/', 1);
        $files = array();
                
        //get the customer name
        $this->load->model('order');
        
        foreach ($map as $file)
        {
            $pos = strpos($file, '.xml');
            $posOrder = strpos($file, 'order');
            
            if ($pos !== false && $posOrder !== false)
            {
                $order = new Order($file);
                $files[] = array (
                    'filename' => substr($file, 0, strlen($file) - 4),
                    'customer' => $order->customer
                        );
            }
        }
	
	// Present the list to choose from
        $this->data['orders'] = $files;
	$this->data['pagebody'] = 'homepage';
	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
        //load the model
        $this->load->model('order');
        
	// Build a receipt for the chosen order
        $order = new Order($filename . '.xml');
	$this->data['filename'] = $filename;
        $this->data['customer'] = $order->customer;
        $this->data['type'] = $order->orderType;
       
        $this->data['burgers'] = $order->burgers;
        $this->data['orderCost'] = $order->orderTotal;
        
        $this->data['orderInstructions'] = $order->orderInstructions;
         
	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
	$this->render();
    }
    

}
