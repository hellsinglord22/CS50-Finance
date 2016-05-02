<?php
    // configuration
    require("../includes/config.php"); 
    
    
    // GET then return the form 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("buy_form.php", ["title" => "buy"]); 
    }
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        /// Variables // 
        $stockSymbol = strtoupper($_POST["symbol"]); 
        $stockShares = $_POST["shares"]; 
        $stockPrice; 
        $stockTotalPrice;
        $stock; 
        
        
        // check if the data is valid 
        if (empty($stockSymbol))
        {
            apologize("You need to provide a stock symbol"); 
        }
        else if (empty($stockShares))
        {
            apologize("You need to provide the number of shares you want to buy"); 
        }
        else if (!preg_match("/^\d+$/", $stockShares))
        {
            apologize("You need to provide a non-negative number as a quantity"); 
        }
        
        // 1. TODO check wether the stock exist 
        $stock = lookup($stockSymbol); 
        if (empty($stock))
        {
            apologize("You didn't enter a valid stock"); 
        }
        
        // 2. TODO check if the value of the price of the stock and if the user have 
        // enough money to buy it 
        $stockPrice = $stock["price"]; 
        $stockTotalPrice = $stockPrice * $stockShares; 
        
        // get user info from the database // 
        $users = CS50::query("SELECT * FROM users WHERE id = ?", 
                    $_SESSION["id"]); 
        $userCash = $users[0]["cash"]; 
        
        if ($userCash < $stockTotalPrice)
        {
            apologize("You don't have enough money"); 
        }
        else
        {
            // 3. TODO Update the moeny and the shares 
            $result = CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $stockTotalPrice,
                    $_SESSION["id"]); 
            
            if ($result == 0) 
            {
                apologize("Failed to update your balance"); 
            }
            
            CS50::query("INSERT INTO portfolios (user_id, symbol, shares) 
                    VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + ?"
                    , $_SESSION["id"], $stockSymbol, $stockShares, $stockShares);
            if ($result == 0)
            {
                apologize("Failed to update stocks"); 
            }
            
            
            
            $result = CS50::query("INSERT INTO history (user_id, transaction, symbol, shares, price) 
                VALUES(?, 'BUY', ?, ?, ?)", $_SESSION["id"], $stockSymbol, $stockShares, $stockTotalPrice); 
                
            if ($result == 0)
            {
                apologize("Failed to update history"); 
            }
            
            
            
            
            // redirect to portofilio 
            redirect('/'); 
            
        }
        
        
    }
    

?>