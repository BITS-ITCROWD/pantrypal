<?php

//table maker function to be extended for drawing iteratively - added by Luke 26/06
// recursive iterator borrowed from http://stackoverflow.com/questions/27280434/display-data-in-mysql-table-newest-to-old for educational purposes


class TableRows extends RecursiveIteratorIterator { 
          function __construct($it) { 
              parent::__construct($it, self::LEAVES_ONLY); 
          }
      
          function current() {
              return "<td style='border:1px solid black;'>" . parent::current(). "</td>";
          }
      
          function beginChildren() { 
              echo "<tr>"; 
          } 
      
          function endChildren() { 
              echo "</tr>" . "\n";
          } 
      }

//end table maker function

?>