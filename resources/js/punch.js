document.addEventListener('DOMContentLoaded', () => {
    const entryBtn = document.getElementById('entry-btn');
    const pauseBtn = document.getElementById('pause-btn');
    const exitBtn = document.getElementById('exit-btn');
    const locationText = document.getElementById('location-text');

    if (!entryBtn || !pauseBtn || !exitBtn) {
        return;
    }

    const buttons = {
        entrada: entryBtn,
        pausa_inicio: pauseBtn,
        saida: exitBtn,
    };

    Object.entries(buttons).forEach(([type, button]) => {
        button.addEventListener('click', () => handlePunch(type, button));
    });

    function handlePunch(punchType, button) {
        if (!navigator.geolocation) {
            alert('Geolocalização não suportada neste navegador.');
            return;
        }

        setLoading(button, true);

        navigator.geolocation.getCurrentPosition(
            (position) => submitPunch(punchType, position, button),
            (error) => {
                console.error('Erro ao obter localização', error);
                alert('Não foi possível obter a localização. Verifique permissões.');
                setLoading(button, false);
            },
            { enableHighAccuracy: true, maximumAge: 0, timeout: 7000 }
        );
    }

    async function submitPunch(punchType, position, button) {
        try {
            const payload = {
                punch_type: punchType,
                lat: position.coords.latitude,
                lng: position.coords.longitude,
                accuracy_m: position.coords.accuracy,
            };

            const { data } = await axios.post('/picagens', payload);

            if (locationText) {
                const { lat, lng } = payload;
                locationText.textContent = `Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}`;
            }

            alert(data.message ?? 'Picagem registada com sucesso.');
        } catch (error) {
            console.error('Falha ao registar picagem', error);
            alert(error.response?.data?.message ?? 'Erro ao registar picagem.');
        } finally {
            setLoading(button, false);
        }
    }

    function setLoading(button, isLoading) {
        button.disabled = isLoading;
        button.classList.toggle('is-loading', isLoading);
    }
});

