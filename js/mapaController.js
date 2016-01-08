app.controller('mapaController', function ($scope, $http, toastr) {
    alert('funci');
});

var map;
var directionsDisplay;
var directionsService;
var objResultRout = {};
var objRotaCaminho = {};

function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();

    var latlng = new google.maps.LatLng(-16.7696477, -49.3319283);

    var options = {
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);
    directionsService = new google.maps.DirectionsService();

    directionsDisplay.setMap(map);
}

function calcRoute(end) {
    var start = '-16.7690814, -49.3283556'
    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.TRANSIT
    };
    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
            objResultRout = result;
        }
    });

}

function carregarPontos() {
    var infowindow = new google.maps.InfoWindow();
    $.getJSON('pontos.json', function (pontos) {
        $.each(pontos, function (index, ponto) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(ponto.Latitude, ponto.Longitude),
                title: ponto.INSTITUICAO,
                map: map
            });
            google.maps.event.addListener(marker, 'click', function () {
                calcRoute(ponto.Latitude + ', ' + ponto.Longitude);

                var caminho = '';
                if (objResultRout) {
                    if (objResultRout.routes[0]) {
                        if (objResultRout.routes[0].legs[0]) {
                            objRotaCaminho = objResultRout.routes[0].legs[0].steps;
                            for (var i = 0; i < objRotaCaminho.length; i++) {
                                var onibus = "";
                                if (objResultRout.routes[0].legs[0].steps[i].travel_mode == "TRANSIT") {
                                    onibus = objResultRout.routes[0].legs[0].steps[i].transit.line.short_name + " - " + objResultRout.routes[0].legs[0].steps[i].transit.line.name;
                                } else {
                                    onibus = "";
                                }
                                //console.log(objResultRout.routes[0].legs[0].steps[i].instructions);
                                caminho = caminho + ', ' + objResultRout.routes[0].legs[0].steps[i].instructions + ",  " + onibus + " - " + objResultRout.routes[0].legs[0].steps[i].distance.value + 'metros';
                                //console.log(objResultRout.routes[0].legs[0]);
                            };
                        }
                    }
                }

                infowindow.setContent('<div><strong>' + ponto.INSTITUICAO + '</strong><br>' +
                  'ENDERECO: ' + ponto.ENDERECO + '<br> Distancia: ' + objResultRout.routes[0].legs[0].distance.text
                  + '<br> Duracao ' + objResultRout.routes[0].legs[0].duration.text + '<br> Caminho: ' + caminho + '</div>');
                infowindow.open(map, this);
            });
        });


    });

}

carregarPontos();


initialize();

