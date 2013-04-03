<?php
  $depth = json_decode(file_get_contents("http://mtgox.com/code/data/getDepth.php"));  

  $asks = $depth->asks;
  $bids = $depth->bids;
  $len = count($asks) ? count($asks) >= count($bids) : count($bids);
  $len = count($asks);
  print "<table>\n";
  print "<tr><th>bids</th><th>fill all bids</th><th>asks</th><th>fill all asks</th></tr>";
  for($iter=0; $iter < $len; ++$iter){
  print "<tr>\n";
    $num_ask = round($asks[$iter][1],4);
    $ask_price = round($asks[$iter][0],4);
    $num_bid = round($bids[$iter][1],4);
    $bid_price = round($bids[$iter][0],4);
    $total_ask += round($num_ask * $ask_price,2);
    $total_bid += round($num_bid * $bid_price,2);
    if( isset($bids[$iter]) )  {
      print "<td>" . $num_bid. ' @ $' . $bid_price . "</td>";
      print "<td>\$$total_bid</td>";
    }
    else{
      print "<td></td><td></td>";
    }
    if( isset($asks[$iter]) )  {
      print "<td>" . $num_ask. ' @ $' . $ask_price . "</td>";
      print "<td>\$$total_ask</td>";
    }
    else{
      print "<td></td><td></td>";
    }
  print "</tr>\n";
  }
  print "</table>\n";
  print '<pre>'; print_r($depth);
  
?>
