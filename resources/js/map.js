let map;
let userMarker;
let punchMarkers = [];
let openInfoWindow = null;

function initMap() {
    const mapElement = document.getElementById("map");
    if (!mapElement || typeof google === 'undefined' || !google.maps) {
        return;
    }

    map = new google.maps.Map(mapElement, {
        zoom: 15,
        center: { lat: 0, lng: 0 }
    });

    userMarker = new google.maps.Marker({
        map: map,
        title: "A tua localização"
    });

    getLocation();
    loadPunches();
    setInterval(loadPunches, 15000);
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

    userMarker.setPosition(userPos);
    map.setCenter(userPos);
}

async function loadPunches() {
    if (!map) return;

    try {
        const response = await fetch('/picagens/latest');
        const { data } = await response.json();

        clearPunchMarkers();

        data.forEach((punch) => {
            const marker = new google.maps.Marker({
                map: map,
                position: {
                    lat: Number(punch.lat),
                    lng: Number(punch.lng),
                },
                title: `${punch.name ?? 'Utilizador'} - ${punch.punch_type}`,
                icon: getIconForPunchType(punch.punch_type),
            });

            const infoContent = `
<div style="min-width:200px;font-family:Roboto,Arial,sans-serif;color:#202124;line-height:1.35;">
  <div style="font-size:14px;font-weight:600;color:#5f6368;margin:0 0 4px 0;">${punch.name ?? 'Utilizador'}</div>
  <div style="font-size:13px;margin:0 0 4px 0;">${punch.position ?? ''}</div>
  <div style="font-size:12px;color:#5f6368;margin:0;">${punch.punch_type} às ${punch.recorded_at ?? ''}</div>
</div>
            `.trim();

            const info = new google.maps.InfoWindow({
                content: infoContent,
                ariaLabel: `${punch.name ?? 'Utilizador'}`,
            });

            marker.addListener('click', () => {
                if (openInfoWindow) {
                    openInfoWindow.close();
                }
                info.open({ anchor: marker, map, shouldFocus: false });
                openInfoWindow = info;
            });

            punchMarkers.push(marker);
        });
    } catch (error) {
        console.error('Erro ao carregar picagens para o mapa', error);
    }
}

function clearPunchMarkers() {
    punchMarkers.forEach((marker) => marker.setMap(null));
    punchMarkers = [];
    if (openInfoWindow) {
        openInfoWindow.close();
        openInfoWindow = null;
    }
}

function getIconForPunchType(punchType) {
    const colors = {
        entrada: '#16a34a', // verde
        pausa_inicio: '#f59e0b', // amarelo
        pausa_fim: '#3b82f6', // azul
        saida: '#ef4444', // vermelho
    };

    const fillColor = colors[punchType] ?? '#ef4444';

    return {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 6,
        fillColor,
        fillOpacity: 0.9,
        strokeColor: '#111827',
        strokeWeight: 1.5,
    };
}

function handleError(error) {
    console.error("Erro na geolocalização:", error);
}
