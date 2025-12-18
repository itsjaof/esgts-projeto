// Sistema de Registar Picagem
class RegistarPicagem {
    constructor() {
        this.currentPosition = null;
        this.watchId = null;
        this.statusInterval = null;
        this.isInPause = false;

        this.dateDisplay = document.getElementById('date-display');
        this.timeDisplay = document.getElementById('time-display');
        this.locationText = document.getElementById('location-text');
        this.currentStatus = document.getElementById('current-status');
        this.hoursToday = document.getElementById('hours-today');

        this.entryBtn = document.getElementById('entry-btn');
        this.pauseBtn = document.getElementById('pause-btn');
        this.exitBtn = document.getElementById('exit-btn');

        this.init();
    }

    init() {
        if (!this.timeDisplay) return;

        this.updateClock();
        setInterval(() => this.updateClock(), 1000);

        this.getLocation();
        this.loadCurrentStatus();

        // Atualizar status a cada 30 segundos
        this.statusInterval = setInterval(() => this.loadCurrentStatus(), 30000);

        if (this.entryBtn) {
            this.entryBtn.addEventListener('click', () => this.registerPunch('entrada'));
        }
        if (this.pauseBtn) {
            this.pauseBtn.addEventListener('click', () => {
                const punchType = this.isInPause ? 'pausa_fim' : 'pausa_inicio';
                this.registerPunch(punchType);
            });
        }
        if (this.exitBtn) {
            this.exitBtn.addEventListener('click', () => this.registerPunch('saida'));
        }
    }

    updateClock() {
        const now = new Date();

        // Formatar data
        const days = ['Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado'];
        const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                       'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        const dayName = days[now.getDay()];
        const day = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        if (this.dateDisplay) {
            this.dateDisplay.textContent = `${dayName}, ${day} de ${month} de ${year}`;
        }

        // Formatar hora
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        if (this.timeDisplay) {
            this.timeDisplay.textContent = `${hours}:${minutes}:${seconds}`;
        }
    }

    getLocation() {
        if (!navigator.geolocation) {
            if (this.locationText) {
                this.locationText.textContent = 'Geolocalização não suportada.';
            }
            return;
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        };

        this.watchId = navigator.geolocation.watchPosition(
            (position) => {
                this.currentPosition = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    accuracy: position.coords.accuracy
                };
                this.updateLocationText();
            },
            (error) => {
                console.error('Erro na geolocalização:', error);
                if (this.locationText) {
                    this.locationText.textContent = 'Erro ao obter localização.';
                }
            },
            options
        );
    }

    async updateLocationText() {
        if (!this.currentPosition || !this.locationText) return;

        try {
            // Usar Geocoding API do Google Maps para obter endereço
            const response = await fetch(
                `https://maps.googleapis.com/maps/api/geocode/json?latlng=${this.currentPosition.lat},${this.currentPosition.lng}&key=AIzaSyBIX4JNyhVQrRQQCnTMH0sL9zt3LEEGAf8`
            );
            const data = await response.json();

            if (data.results && data.results.length > 0) {
                const result = data.results[0];
                const formattedAddress = result.formatted_address;
                const placeId = result.place_id || null;

                // Armazenar o endereço formatado e place_id no objeto currentPosition
                this.currentPosition.formatted_address = formattedAddress;
                this.currentPosition.google_place_id = placeId;
                this.currentPosition.raw_api_response = result;

                this.locationText.textContent = formattedAddress;
            } else {
                this.locationText.textContent = `Lat: ${this.currentPosition.lat.toFixed(6)}, Lng: ${this.currentPosition.lng.toFixed(6)}`;
            }
        } catch (error) {
            console.error('Erro ao obter endereço:', error);
            this.locationText.textContent = `Lat: ${this.currentPosition.lat.toFixed(6)}, Lng: ${this.currentPosition.lng.toFixed(6)}`;
        }
    }

    async loadCurrentStatus() {
        try {
            const response = await fetch('/picagens/current-status', {
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Erro ao carregar estado');
            }

            const data = await response.json();

            // Atualizar estado atual
            if (this.currentStatus) {
                this.currentStatus.textContent = data.current_status || 'Sem registo';

                // Adicionar classe CSS baseada no estado
                this.currentStatus.className = 'status-value';
                if (data.current_status === 'A trabalhar') {
                    this.currentStatus.classList.add('status-working');
                    this.entryBtn.disabled = true;
                } else if (data.current_status === 'Em pausa') {
                    this.currentStatus.classList.add('status-paused');
                    this.entryBtn.disabled = true;
                    this.exitBtn.disabled = true;
                } else {
                    this.currentStatus.classList.add('status-none');
                    this.exitBtn.disabled = true;
                    this.pauseBtn.disabled = true;
                }
            }

            // Atualizar estado de pausa e botão
            this.isInPause = data.current_status === 'Em pausa';
            this.updatePauseButton();

            // Atualizar horas trabalhadas
            if (this.hoursToday) {
                const hours = data.hours_today || 0;
                const minutes = data.minutes_today || 0;
                this.hoursToday.textContent = `${hours}h ${String(minutes).padStart(2, '0')}m`;
            }

            return data.currentStatus
        } catch (error) {
            console.error('Erro ao carregar estado:', error);
        }
    }

    async registerPunch(punchType) {
        if (!this.currentPosition) {
            alert('A aguardar localização... Por favor, aguarde alguns segundos.');
            return;
        }

        // Desabilitar botões durante o envio
        this.setButtonsEnabled(false);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const response = await fetch('/picagens', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    punch_type: punchType,
                    lat: this.currentPosition.lat,
                    lng: this.currentPosition.lng,
                    accuracy_m: this.currentPosition.accuracy ? (this.currentPosition.accuracy / 1000).toFixed(2) : null,
                    formatted_address: this.currentPosition.formatted_address || null,
                    google_place_id: this.currentPosition.google_place_id || null,
                    raw_api_response: this.currentPosition.raw_api_response || null,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Erro ao registar picagem');
            }

            // Sucesso
            this.showSuccessMessage(`Picagem de ${this.getPunchTypeLabel(punchType)} registada com sucesso!`);

            // Atualizar estado após 1 segundo
            setTimeout(() => {
                if (punchType == 'entrada') {
                    this.entryBtn.disabled = true;
                } else if (punchType == 'saida') {
                    this.exitBtn.disabled = true;
                    this.pauseBtn.disabled = true;
                }

                this.loadCurrentStatus();
            }, 1000);

        } catch (error) {
            console.error('Erro ao registar picagem:', error);
            alert('Erro ao registar picagem: ' + error.message);
        } finally {
            this.setButtonsEnabled(true);
        }
    }

    getPunchTypeLabel(punchType) {
        const labels = {
            'entrada': 'Entrada',
            'saida': 'Saída',
            'pausa_inicio': 'Pausa',
            'pausa_fim': 'Fim de Pausa'
        };
        return labels[punchType] || punchType;
    }

    updatePauseButton() {
        if (!this.pauseBtn) return;

        const pauseBtnSpan = this.pauseBtn.querySelector('span');
        const pauseBtnIcon = this.pauseBtn.querySelector('i');

        if (this.isInPause) {
            if (pauseBtnSpan) pauseBtnSpan.textContent = 'Terminar Pausa';
            if (pauseBtnIcon) {
                pauseBtnIcon.className = 'fas fa-play-circle';
            }
        } else {
            if (pauseBtnSpan) pauseBtnSpan.textContent = 'Registar Pausa';
            if (pauseBtnIcon) {
                pauseBtnIcon.className = 'fas fa-pause';
            }
        }
    }

    setButtonsEnabled(enabled) {
        if (this.entryBtn) this.entryBtn.disabled = !enabled;
        if (this.pauseBtn) this.pauseBtn.disabled = !enabled;
        if (this.exitBtn) this.exitBtn.disabled = !enabled;
    }

    showSuccessMessage(message) {
        // Criar elemento de mensagem temporária
        const messageEl = document.createElement('div');
        messageEl.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--color-success);
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: var(--shadow-md);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        messageEl.textContent = message;
        document.body.appendChild(messageEl);

        setTimeout(() => {
            messageEl.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => messageEl.remove(), 300);
        }, 3000);
    }

    destroy() {
        if (this.watchId !== null) {
            navigator.geolocation.clearWatch(this.watchId);
        }
        if (this.statusInterval) {
            clearInterval(this.statusInterval);
        }
    }
}

// Inicializar quando a página carregar
document.addEventListener('DOMContentLoaded', () => {
    // Só inicializar se estivermos na página de registar picagem
    if (document.getElementById('time-display')) {
        new RegistarPicagem();
    }
});

