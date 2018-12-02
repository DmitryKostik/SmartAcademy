$(document).ready(function() {

	var 	priceDomen = 500,
				priceServer = 20000,
				priceService = 10000,
				priceDistribute = 0,
				total_sum = 30500,
				domenName = {
				"smart-donampa.ru":{1:500},
				"smart-donampa.com":{1:660},
				"smart-donampa.net":{1:858},
				"smart-donampa.org":{1:990},
				"smart-donampa.co":{1:200}
				},
        distributeName = {
          "Android":{1:20000},
          "iOS":{1:45000},
          "Windows Mobile":{1:10000},
          "WebServer":{1:30000}
        },
				serverName = {
					"Сервер HPE ProLiant ML10 Gen9 (837826-421)":{1:20000},
					"Сервер Dell PowerEdge T30":{1:55000},
					"Сервер Supermicro 5019R-M":{1:208000}
				},
				serviceName = {
          "Минимальное развертывание мобильных сервисов":{1:10000},
					"Базовое развертывание мобильных сервисов":{1:30000},
					"Полное развертывание мобильных сервисов":{1:50000}
				};

				insertPriceDomen();
        insertPriceServer();
        insertPriceService();
        insertPriceDistribute();

  			function insertPriceDomen(){
  				var html = '';
  				for(domen in domenName){
  					html+='<option value = "'+domen +'" domen-price = "' + domenName[domen][1] + '">' + domen + '</option>';
  				}
  				$('#domen-name').empty();
  				$('#domen-name').append(html);
        }

				function insertPriceServer(){
					var html = '';
					for(server in serverName){
						html+='<option value = "'+server +'" server-price = "' + serverName[server][1] + '">' + server + '</option>';
					}
					$('#server-name').empty();
					$('#server-name').append(html);
				}

				function insertPriceService(){
					var html = '';
					for(service in serviceName){
						html+='<option value = "'+service +'" service-price = "' + serviceName[service][1] + '">' + service + '</option>';
					}
					$('#service-name').empty();
					$('#service-name').append(html);
				}

        function insertPriceDistribute(){
					var html = '';
					for(distribute in distributeName){
						html+='<div class="d-block"><label><input class="pl-2" type="checkbox" distribute-price = "' + distributeName[distribute][1] + '"> '+ distribute +'</label></div>';
					}
					console.log(html);
					$('#distribute-name').empty();
					$('#distribute-name').append(html);
				}

        function total(){
          total_sum = parseInt(priceDomen) + parseInt(priceServer) + parseInt(priceService) + parseInt(priceDistribute);
          $('#tb-sum').text(total_sum);
        }

				$('#domen-name').change(function(){
					priceDomen = $('#domen-name option:selected').attr('domen-price');
					$('#tb-domen').text(priceDomen);
          total();
        });

				$('#server-name').change(function(){
          priceServer = $('#server-name option:selected').attr('server-price');
          $('#tb-server').text(priceServer);
          total();
        });

				$('#service-name').change(function(){
					priceService = $('#service-name option:selected').attr('service-price');
					$('#tb-service').text(priceService);
          total();
        });

        $('#distribute-name').change(function(){
         priceDistribute=0;
         $("input[type='checkbox']:checked").each(function () {
           priceDistribute+=parseInt($(this).attr('distribute-price'));
           console.log($(this).attr('distribute-price'));
         });
         $('#tb-distribute').text(priceDistribute);
         total();
        });

});
