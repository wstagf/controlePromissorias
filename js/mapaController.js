app.controller('mapaController', function ($scope, $http, toastr) {
    $scope.Endereco = {
        id: 0,
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        cidade_id: 0,
        cep: 0,
        latitude: 0,
        longetude: 0,
        ponto_referencia: ''
    };
});

var map;

function initialize(lat, long, ponto) {
    var latlng = new google.maps.LatLng(lat, long);
    var options = {
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapa"), options);
    carregaEndereco(lat, long, ponto);
}

function carregaEndereco(lat, long, ponto) {
    var infowindow = new google.maps.InfoWindow();

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, long),
        map: map
    });

    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent('<div><strong>Endereço</strong><br>' +
          'Rua/Avenida: ' + ponto.logradouro + ', Número: ' + ponto.numero + '<br> Complemento: '
          + ponto.complemento + '<br> Bairro/Setor: ' + ponto.bairro + ' <br/> Ponto de Referencia: ' + ponto.ponto_referencia + '</div>');
        infowindow.open(map, this);
        console.log(ponto);
    });

}


function fechaMapa() {
    $('#mapaPainel').hide();
}
