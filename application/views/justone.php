<div class="row">
    <h3>
        {filename} for {customer} ({type})
    </h3>
    
    <h5>
        Order Instructions: {orderInstructions} <br/>
    </h5>
    <p>
        {burgers}
            <br />
            *Burger #{burgerNum}* <br/>
            Base: {patty} <br/>
            Cheese: {cheese}  <br/>
            Toppings: {toppings} <br/>
            Sauce: {sauces} <br/>
            Burger total: ${burgerCost} <br/>     
            <br/> Special Burger Instructions: {instructions} <br/>
        {/burgers}
    </p>
    
    <p style="font-weight:bold;">
        Order Total: $ {orderCost} <br/>
    </p>
    
</div>