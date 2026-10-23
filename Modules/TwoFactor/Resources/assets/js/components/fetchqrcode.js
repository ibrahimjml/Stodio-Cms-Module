const DEFAULT_ERROR = 'Unable to load the QR code. Please try again.';

export async function fetchQrCode(endpoint, errorMessage = DEFAULT_ERROR) {
    const response = await fetch(endpoint, {
        headers: {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
    });

    if (!response.ok) {
        throw new Error(errorMessage);
    }

    const data = await response.json();

    return {
        qrcode: data.qrcode,
        secret: data.secret,
    };
}

export function createQrCodeState(endpoint, errorMessage = DEFAULT_ERROR) {
    return {
        qrCode: '',
        secret: '',
        loading: false,
        error: '',

        resetQrCode() {
            this.qrCode = '';
            this.secret = '';
            this.loading = false;
            this.error = '';
        },

        async loadQrCode() {
            if (this.loading) {
                return;
            }

            this.loading = true;
            this.error = '';
            this.qrCode = '';
            this.secret = '';

            try {
                const data = await fetchQrCode(endpoint, errorMessage);

                this.qrCode = data.qrcode;
                this.secret = data.secret;
            } catch (exception) {
                this.error = exception.message || errorMessage;
            } finally {
                this.loading = false;
            }
        },
    };
}
