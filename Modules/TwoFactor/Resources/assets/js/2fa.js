import Alpine from '@core/alpine';
import { createConfirmChallengeState } from './components/confirm-challenge';
import { createDisableState } from './components/disable';
import { createTwoFactorWizard } from './components/wizard';

document.addEventListener('alpine:init', () => {
    Alpine.data('twoFactorWizard', createTwoFactorWizard);
    Alpine.data('twoFactorDisable', createDisableState);
    Alpine.data('twoFactorChallenge', createConfirmChallengeState);
});

if (! window.__alpineStarted) {
    const startAlpine = () => {
        if (window.__alpineStarted) {
            return;
        }

        Alpine.start();
        window.__alpineStarted = true;
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startAlpine, { once: true });
    } else {
        startAlpine();
    }
}
