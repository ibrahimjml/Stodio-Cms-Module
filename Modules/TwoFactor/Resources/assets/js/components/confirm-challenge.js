const DEFAULT_ERROR = 'Unable to verify the authentication code. Please try again.';

async function resolveErrorMessage(response, fallback) {
    try {
        const data = await response.json();

        return data.errors?.code?.[0] || data.errors?.recovery_code?.[0] || data.message || fallback;
    } catch {
        return fallback;
    }
}

export async function confirmChallenge(endpoint, options = {}) {
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

export function createConfirmChallengeState(config = {}) {
    return {
        code: '',
        recoveryCode: '',
        confirming: false,
        error: '',

        get isCodeComplete() {
            return /^\d{6}$/.test(this.code);
        },

        get hasRecoveryCode() {
            return this.recoveryCode.trim().length > 0;
        },

        get canConfirm() {
            return (this.isCodeComplete || this.hasRecoveryCode) && !this.confirming;
        },

        sanitizeCode(event) {
            const value = (event?.target?.value ?? this.code).replace(/\D/g, '').slice(0, 6);

            this.code = value;

            if (event?.target) {
                event.target.value = value;
            }
        },

        resetChallenge() {
            this.code = '';
            this.recoveryCode = '';
            this.confirming = false;
            this.error = '';
        },

        async confirm() {
            if (!this.canConfirm) {
                return;
            }

            this.confirming = true;
            this.error = '';

            try {
                const useRecoveryCode = !this.isCodeComplete && this.hasRecoveryCode;

                const data = await confirmChallenge(config.endpoint, {
                    method: config.method,
                    csrfToken: config.csrfToken,
                    payload: {
                        code: useRecoveryCode ? null : this.code,
                        recovery_code: useRecoveryCode ? this.recoveryCode.trim() : null,
                    },
                    errorMessage: config.errorMessage,
                });

                window.flashAlert?.('success', data.message || config.successMessage);
                window.location.assign(data.redirect);
            } catch (exception) {
                this.error = exception.message || config.errorMessage || DEFAULT_ERROR;
                window.flashAlert?.('error', this.error);
            } finally {
                this.confirming = false;
            }
        },
    };
}
