import { createEnableState } from './enable';
import { createQrCodeState } from './fetchqrcode';
import { createSteps } from './steps';

function composeState(...states) {
    const target = {};

    states.forEach((state) => {
        Object.defineProperties(target, Object.getOwnPropertyDescriptors(state));
    });

    return target;
}

export function createTwoFactorWizard(config = {}) {
    return composeState(
        createSteps(config.totalSteps || 3),
        createQrCodeState(config.endpoint, config.errorMessage),
        createEnableState(config.enable),
        {
            init() {
                this.$watch('step', (step) => {
                    if (step === 2) {
                        this.loadQrCode();
                    }
                });
            },

            start() {
                this.resetSteps();
                this.resetQrCode();
                this.resetEnable();
            },
        }
    );
}
