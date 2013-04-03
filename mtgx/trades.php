<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>mtgox ticker and trades</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="utils.js"></script>
<style>
  .depth { background: #bbb; }
  .trade { background: red; }
</style>
</head>
<body>
<div id="status">Websocket not working</div>
<div id="disconnect">Disconnect</div>
<div id="ticker">
Last: <span id="last">00</span>
Buy: <span id="buy">00</span>
Sell: <span id="sell">00</span>
Low: <span id="low">00</span>
High: <span id="high">00</span>
Volume: <span id="volume">00</span>
</div>
<section id="content"></section>
<script>

$('#disconnect').click( function() {
  ws.close();
});

var ws = new WebSocket("ws://websocket.mtgox.com/mtgox"); 
ws.onopen = function(){  
  $("#status").html("Connected");
}  

ws.onmessage = function(msg){  
  var chunk = $.parseJSON(msg.data);
  if(chunk['channel']=='24e67e0d-1cad-4cc0-9e7a-f8523ef460fe'){
    _handle_depth(chunk);
  }
  else if(chunk['channel']==="dbf1dee9-4f2e-4a08-8cb7-748919a71b21"){
    _handle_trade(chunk);
  }
  else if(chunk['channel']==="d5f06780-30a8-4a48-a2f8-7ed181b4a13f"){
    _update_ticker(chunk);
  }
  else{
    console.log("something got through");
    console.log(chunk);
  }
  var len = $('#content div').length;
  if (len > 0){
    $('#content div:gt(24)').fadeOut('slow', function(){ $(this).remove(); });
  }
}  

function _handle_trade(chunk){
  if (chunk['trade']===undefined) { return; }
  var amount = chunk['trade']['amount'];
  var price = chunk['trade']['price'];
  var time = new Date(chunk['trade']['date']*1000);
  var hours = time.getHours();
  var minutes = time.getMinutes();
  var seconds = time.getSeconds();
  
  var out = hours + ':' + minutes + ':' + seconds + '--          ' + amount + " @ $" + price;
  $('#content').prepend('<div class="trade">Trade! '+out+'</div>');
}

function _update_ticker(chunk){
  if (chunk['ticker']===undefined) { return; }
  var ticker = chunk['ticker'];
  $('#buy').html(ticker['buy']);
  $('#sell').html(ticker['sell']);
  $('#low').html(ticker['low']);
  $('#high').html(ticker['high']);
  $('#last').html(ticker['last']);
  $('#volume').html(ticker['vol']);
}

function _handle_depth(chunk){
  return;
  if(chunk['depth']===undefined){ return; }
  var volume = chunk['depth']['volume'];
  var price = chunk['depth']['price'];
  var type = chunk['depth']['type'];
  if (type == 1) { type = 'ask'; } else { type='bid' } 
  $('#content').prepend('<div class="depth ' + type + '">'+type + ' ' + volume + ' @ $' + price +'</div>');
}
</script>
</body>
</html>
