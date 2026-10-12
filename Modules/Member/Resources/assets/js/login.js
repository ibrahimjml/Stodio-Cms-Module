
import Alpine from "@core/alpine";
import { clearFormErrors, showFormErrors } from "@core/form/form-error";

document.addEventListener("alpine:init", () => {
    Alpine.data("loginForm", () => ({
        loading: false,

        async submit() {
            const form = this.$root;

            const login = form.querySelector("#login")?.value.trim();
            const password = form.querySelector("#password")?.value;
            const remember = form.querySelector("#remember")?.checked ?? false;

            if (!login || !password) {
                return;
            }

            clearFormErrors(form);

            this.loading = true;

            try {
                const response = await fetch(form.action, {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content"),
                        "X-Requested-With": "XMLHttpRequest",
                    },

                    body: JSON.stringify({
                        login,
                        password,
                        remember,
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    const hasFieldErrors =
                        data.errors && Object.keys(data.errors).length > 0;

                    if (hasFieldErrors) {
                        showFormErrors(form, data.errors);
                    }

                    const generic =
                        data.message === "The given data was invalid.";

                    if (!hasFieldErrors || !generic) {
                        window.flashAlert(
                            "error",
                            data.message || "Login failed.",
                        );
                    }

                    return;
                }

                if (data.redirect) {
                    window.location.assign(data.redirect);

                    return;
                }
                window.flashAlert("success", "Login successful.");
                window.location.reload();
            } catch (error) {
                console.error(error);
                window.flashAlert(
                    "error",
                    "Something went wrong. Please try again.",
                );
            } finally {
                this.loading = false;
            }
        },
    }));
});

Alpine.start();
