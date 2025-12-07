let map;
let marker;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: { lat: 0, lng: 0 }
    });

    marker = new google.maps.Marker({
        map: map,
        title: "A tua localização"
    });

    getLocation();
}

window.onload = initMap;

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(updatePosition, handleError, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 5000
        });
    } else {
        alert("Geolocalização não suportada.");
    }
}

function updatePosition(position) {
    const userPos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
    };

    // Atualiza posição do marcador
    marker.setPosition(userPos);

    // Centraliza o mapa (opcional)
    map.setCenter(userPos);
}

function handleError(error) {
    console.error("Erro na geolocalização:", error);
}
