<?php
$sql="INSERT INTO $article (headline, content)
VALUES ('$_POST[headline]', '$_POST[content]')";

$qry_6_12 .= "  SELECT count(ncropfarmingreasonid) as counted , " ;

     for($i=2;$i<=$count_row;$i++) // loop the number of rows and used $i as ncropfarmingreasonid 
          {           
            if(($count_row-$i)==0)
              {
                 $qry_6_12 .= "SUM(CASE WHEN ncropfarmingreasonid = ".$i." THEN 1
                 ELSE 0 END) a".$i."";
              }  
            else 
              {
                 $qry_6_12 .= "SUM(CASE WHEN ncropfarmingreasonid = ".$i." THEN 1  
                 ELSE 0 END) a".$i.",";                                  
              }        
          }
      $qry_6_12 .= " FROM tbl_climatechange as c, tbl_household as h, tbl_barangay as b where h.chholdnumber=c.chholdnumber and b.cbrgycode=h.cbrgycode and b.cbrgyname = 'AMPAYON' ";
      $query_6_12 = pg_query($qry_6_12);