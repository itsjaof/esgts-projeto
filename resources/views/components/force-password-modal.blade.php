@if (session('force_password_reset'))
    <div class="password-modal-overlay active" id="forcePasswordResetModal">
        <div class="password-modal">
            <div class="password-modal-header">
                <h2>Altere a sua palavra-passe</h2>
                <p class="password-modal-subtitle">Está a usar a password padrão. Defina uma nova para continuar com mais segurança.</p>
            </div>
            <form class="password-modal-form" method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="password-form-group">
                    <label for="new-password">Nova palavra-passe</label>
                    <input type="password" id="new-password" name="password" required minlength="8" autocomplete="new-password" placeholder="********">
                </div>
                <div class="password-form-group">
                    <label for="new-password-confirm">Confirmar palavra-passe</label>
                    <input type="password" id="new-password-confirm" name="password_confirmation" required minlength="8" autocomplete="new-password" placeholder="********">
                </div>
                <div class="password-modal-actions">
                    <button type="submit" class="btn-primary">Guardar nova palavra-passe</button>
                </div>
            </form>
        </div>
    </div>
@endif


