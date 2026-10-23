export function createSteps(totalSteps = 3) {
    return {
        step: 1,
        totalSteps,

        get isFirstStep() {
            return this.step <= 1;
        },

        get isLastStep() {
            return this.step >= this.totalSteps;
        },

        goToStep(step) {
            this.step = Math.min(Math.max(step, 1), this.totalSteps);
        },

        nextStep() {
            this.goToStep(this.step + 1);
        },

        previousStep() {
            this.goToStep(this.step - 1);
        },

        resetSteps() {
            this.step = 1;
        },
    };
}
