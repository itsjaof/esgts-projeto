// Calendar functionality for picagens page
class PicagensCalendar {
    constructor() {
        this.currentDate = new Date();
        this.selectedDate = new Date();
        this.calendarDays = document.getElementById('calendarDays');
        this.currentMonthYear = document.getElementById('currentMonthYear');
        this.prevMonthBtn = document.getElementById('prevMonth');
        this.nextMonthBtn = document.getElementById('nextMonth');
        this.picagensList = document.getElementById('picagensList');

        this.monthNames = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        this.init();
    }

    init() {
        if (!this.calendarDays) return;

        this.renderCalendar();
        this.attachEventListeners();
        this.loadPicagensForDate(this.selectedDate);
    }

    attachEventListeners() {
        if (this.prevMonthBtn) {
            this.prevMonthBtn.addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                this.renderCalendar();
            });
        }

        if (this.nextMonthBtn) {
            this.nextMonthBtn.addEventListener('click', () => {
                this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                this.renderCalendar();
            });
        }
    }

    renderCalendar() {
        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();

        // Update month/year display
        if (this.currentMonthYear) {
            this.currentMonthYear.textContent = `${this.monthNames[month]} ${year}`;
        }

        // Clear calendar
        if (this.calendarDays) {
            this.calendarDays.innerHTML = '';
        }

        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < startingDayOfWeek; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day other-month';
            this.calendarDays.appendChild(emptyDay);
        }

        // Add days of the month
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;

            const currentDayDate = new Date(year, month, day);
            currentDayDate.setHours(0, 0, 0, 0);

            // Check if it's today
            if (currentDayDate.getTime() === today.getTime()) {
                dayElement.classList.add('today');
            }

            // Check if it's selected
            const selectedDateNormalized = new Date(this.selectedDate);
            selectedDateNormalized.setHours(0, 0, 0, 0);
            if (currentDayDate.getTime() === selectedDateNormalized.getTime()) {
                dayElement.classList.add('selected');
            }

            // Add click event
            dayElement.addEventListener('click', () => {
                this.selectDate(new Date(year, month, day));
            });

            // TODO: Add has-picagens class if there are picagens for this day
            // This will be implemented when backend integration is ready
            // if (this.hasPicagensForDate(currentDayDate)) {
            //     dayElement.classList.add('has-picagens');
            // }

            this.calendarDays.appendChild(dayElement);
        }

        // Add empty cells for days after the last day of the month
        const totalCells = startingDayOfWeek + daysInMonth;
        const remainingCells = 42 - totalCells; // 6 rows * 7 days = 42
        for (let i = 0; i < remainingCells && totalCells + i < 42; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day other-month';
            this.calendarDays.appendChild(emptyDay);
        }
    }

    selectDate(date) {
        this.selectedDate = new Date(date);
        this.renderCalendar();
        this.loadPicagensForDate(this.selectedDate);
    }

    loadPicagensForDate(date) {
        // Format date for API call (YYYY-MM-DD)
        const formattedDate = date.toISOString().split('T')[0];

        this.showLoadingState();

        fetch(`/picagens/data?date=${formattedDate}`, {
            headers: {
                'Accept': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                this.displayPicagens(data?.data || []);
            })
            .catch(error => {
                console.error('Erro ao carregar picagens:', error);
                if (this.picagensList) {
                    this.picagensList.innerHTML = `
                        <div style="text-align: center; padding: 40px; color: var(--color-error);">
                            <i class="fas fa-exclamation-triangle" style="font-size: 24px; margin-bottom: 12px;"></i>
                            <p>Não foi possível carregar as picagens.</p>
                        </div>
                    `;
                }
            });
    }

    showLoadingState() {
        if (this.picagensList) {
            this.picagensList.innerHTML = `
                <div style="text-align: center; padding: 40px; color: var(--color-text-secondary);">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 12px;"></i>
                    <p>A carregar picagens...</p>
                </div>
            `;
        }
    }

    displayPicagens(picagens) {
        if (!this.picagensList) return;

        if (picagens.length === 0) {
            this.picagensList.innerHTML = `
                <div style="text-align: center; padding: 40px; color: var(--color-text-secondary);">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 12px; opacity: 0.3;"></i>
                    <p>Nenhuma picagem registada para este dia.</p>
                </div>
            `;
            return;
        }

        // Build HTML for picagens
        let html = '';
        picagens.forEach(picagem => {
            const entradaTime = picagem.hora_entrada || '--:--';
            const saidaTime = picagem.hora_saida || '--:--';
            const pausaInicio = picagem.hora_pausa_inicio || '--:--';
            const pausaFim = picagem.hora_pausa_fim || '--:--';
            const status = picagem.status || 'Pendente';
            const statusClass = this.getStatusClass(status);

            html += `
                <div class="picagem-card">
                    <div class="picagem-info">
                        <div class="picagem-name">${picagem.nome || 'Nome'}</div>
                        <div class="picagem-times">
                            <span class="picagem-time">
                                <i class="fas fa-sign-in-alt"></i> ${entradaTime}
                            </span>
                            <span class="picagem-time">
                                <i class="fas fa-coffee"></i> ${pausaInicio}
                            </span>
                            <span class="picagem-time">
                                <i class="fas fa-play-circle"></i> ${pausaFim}
                            </span>
                            <span class="picagem-time">
                                <i class="fas fa-sign-out-alt"></i> ${saidaTime}
                            </span>
                        </div>
                    </div>
                    <span class="picagem-status ${statusClass}">${status}</span>
                </div>
            `;
        });

        this.picagensList.innerHTML = html;
    }

    getStatusClass(status) {
        const statusLower = status.toLowerCase();
        if (statusLower.includes('completo') || statusLower.includes('concluído')) {
            return 'status-complete';
        } else if (statusLower.includes('pendente')) {
            return 'status-pending';
        } else if (statusLower.includes('atraso')) {
            return 'status-late';
        }
        return '';
    }

    // Helper method to check if a date has picagens (for future use)
    hasPicagensForDate(date) {
        // TODO: Implement when backend is ready
        return false;
    }
}

// Initialize calendar when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize if we're on the picagens page
    if (document.getElementById('calendarDays')) {
        new PicagensCalendar();
    }
});



