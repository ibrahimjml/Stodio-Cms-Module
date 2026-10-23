const DEFAULT_ERROR = 'Unable to disable two-factor authentication. Please try again.';

async function resolveErrorMessage(response, fallback) {
    try {
        const data = await response.json();

        return data.errors?.code?.[0] || data.message || fallback;
    } catch {
        return fallback;
    }
}

export async function disableTwoFactor(endpoint, options = {}) {
    const response = await fetch(endpoint, {
        method: options.method || 'DELETE',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': options.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        credentials: 'same-origin',
        body: JSON.stringify(options.payload || {}),
    });

    if (!response.ok) {
        throw new Error(await resolveErrorMessage(response, options.errorMessage || DEFAULT_ERROR));
    }

    return response.json().catch(() => ({}));
}

export function createDisableState(config = {}) {
    return {
        code: '',
        loading: false,
        error: '',
        success: false,

        get isCodeComplete() {
            return /^\d{6}$/.test(this.code);
        },

        get canDisable() {
            return this.isCodeComplete && !this.loading && !this.success;
        },

        sanitizeCode(event) {
            const value = (event?.target?.value ?? this.code).replace(/\D/g, '').slice(0, 6);

            this.code = value;

            if (event?.target) {
                event.target.value = value;
            }
        },

        resetDisable() {
            this.code = '';
            this.loading = false;
            this.error = '';
            this.success = false;
        },

        async disable() {
            if (!this.canDisable) {
                return;
            }

            this.loading = true;
            this.error = '';

            try {
                await disableTwoFactor(config.endpoint, {
                    method: config.method,
                    csrfToken: config.csrfToken,
                    payload: { code: this.code },
                    errorMessage: config.errorMessage,
                });

                this.success = true;
                window.flashAlert?.('success', config.successMessage);

                window.setTimeout(() => {
                    window.location.reload();
                }, 300);
            } catch (exception) {
                this.error = exception.message || config.errorMessage || DEFAULT_ERROR;
            } finally {
                this.loading = false;
            }
        },
    };
}
