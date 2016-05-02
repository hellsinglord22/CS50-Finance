<?php
     // configuration
    require("../includes/config.php"); 
    
     // GET then return the form 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $rows = CS50::query("SELECT * FROM history WHERE user_id = ?", $_SESSION["id"]); 
        
        // make sure you did select anything before rendering 
        if (!empty($rows))
        {
            
             render("history_display.php", ["title" => "history", "positions" => $rows]); 
        }
        else 
        {
            apologize("No transaction were made !!!");
        }
        
    }
    else 
    {
        apologize("Access denied"); 
    }



?>