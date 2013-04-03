<?php
  ini_set('user_agent', 'iusecoins.com depth chart');
  $depth = json_decode(file_get_contents("http://mtgox.com/code/data/getDepth.php"));  
  $num_bid = $bid_price = $total_bid =  $total_coins_bid =0;
  $num_ask = $bid_ask = $total_ask =  $total_coins_ask =0;

  $asks = $depth->asks;
  $bids = array_reverse($depth->bids);
  $len = count($asks) ? count($asks) >= count($bids) : count($bids);
  $len = count($asks);
  $fab_code = <<<ZZZZ
  <!-- Beginning of Operation Fabulous ad code: -->
  <!-- Ad box ID: 239 -->
  <script type="text/javascript">
  <!--
  var pw_d=document;
  pw_d.bch_wid="239";
  //-->
  </script>
  <div class="adbox">
  <script type="text/javascript" src="http://www.operationfabulous.com/ads/ad_display.js"></script>
  <noscript>
  <map name="admap239"><area href="http://www.operationfabulous.com/ads/link_nojs.php?wid=239" shape="default" alt="Operation Fabulous Ads" /></map>
  <img src="http://www.operationfabulous.com/ads/nojs.php?wid=239" usemap="#admap239" border="0" alt="Operation Fabulous Ads" />
  </noscript><!-- End of Operation Fabulous ad code. -->
  </div>
ZZZZ;
  print $fab_code;
  print "<table>\n";
  print "<tr><th>#coins</th><th>bids</th><th>fill all bids</th><th>asks</th><th>fill all asks</th><th>#coins</th></tr>";
  for($iter=0; $iter < $len; ++$iter){
  print "<tr>\n";
    if( isset($bids[$iter]) )  {
      $num_bid = round($bids[$iter][1],4);
      $bid_price = round($bids[$iter][0],4);
      $total_bid += round($num_bid * $bid_price,2);
      $total_coins_bid += round($num_bid,2);

      print "<td>$total_coins_bid BTC</td>";
      print "<td>" . $num_bid. ' @ $' . $bid_price . "</td>";
      print "<td>\$$total_bid</td>";
    }
    else{
      print "<td></td><td></td><td></td>";
    }
    if( isset($asks[$iter]) )  {
      $num_ask = round($asks[$iter][1],4);
      $ask_price = round($asks[$iter][0],4);
      $total_ask += round($num_ask * $ask_price,2);
      $total_coins_ask += round($num_ask,2);
      print "<td>" . $num_ask. ' @ $' . $ask_price . "</td>";
      print "<td>\$$total_ask</td>";
      print "<td>$total_coins_ask BTC</td>";
    }
    else{
      print "<td></td><td></td><td></td>";
    }
  print "</tr>\n";
  }
  print "</table>\n";
  
?>
