<div id="middle">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Time</th>
                <th>Transaction</th>
                <th>Symbol</th>
                <th>Shares</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        
        <tbody>
                            
            <!--Check if its not empty -->
            <?php
                if(!empty($positions))
                {
                    foreach ($positions as $position)
                    {
                        // print tabel information 

                        
                        print("<tr>");
                        print("<td>" . $position["time"] . "</td>");
                        print("<td>" . $position["transaction"]   . "</td>"); 
                        print("<td>" . $position["symbol"] . "</td>");
                        print("<td>" . $position["shares"]  . "</td>"); 
                        print("<td>" . number_format($position["price"], 2)  . "$" . "</td>");
                        print("</tr>");
                    }
                }
               
            ?>
        </tbody>

    </table>
</div>
