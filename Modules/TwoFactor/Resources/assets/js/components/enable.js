const DEFAULT_ERROR = 'Unable to enable two-factor authentication. Please try again.';

async function resolveErrorMessage(response, fallback) {
    try {
        const data = await response.json();

        return data.errors?.code?.[0] || data.message || fallback;
    } catch {
        return fallback;
    }
}

export async function enableTwoFactor(endpoint, options = {}) {
    const response = await fetch(endpoint, {
        method: options.method || 'POST',
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

export function createEnableState(config = {}) {
    return {
        code: '',
        confirming: false,
        confirmError: '',
        success: false,

        get isCodeComplete() {
            return /^\d{6}$/.test(this.code);
        },

        get canConfirm() {
            return this.isCodeComplete && !this.confirming && !this.success;
        },

        sanitizeCode(event) {
            const value = (event?.target?.value ?? this.code).replace(/\D/g, '').slice(0, 6);

            this.code = value;

            if (event?.target) {
                event.target.value = value;
            }
        },

        resetEnable() {
            this.code = '';
            this.confirming = false;
            this.confirmError = '';
            this.success = false;
        },

        async confirm() {
            if (!this.canConfirm) {
                return;
            }

            this.confirming = true;
            this.confirmError = '';

            try {
                await enableTwoFactor(config.endpoint, {
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
                this.confirmError = exception.message || config.errorMessage || DEFAULT_ERROR;
            } finally {
                this.confirming = false;
            }
        },
    };
}
