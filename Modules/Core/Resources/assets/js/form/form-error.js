const clearFormErrors = (form) => {

    form.querySelectorAll("[data-error-for]").forEach((element) => {
        element.textContent = "";
        element.removeAttribute("title");
    });

    form.querySelectorAll("input, textarea, select").forEach((input) => {
        input.classList.remove("border-red-500", "bg-white");
        input.classList.add("border-gray-300", "bg-gray-50");
    });
};

const showFormErrors = (form,errors) => {
    Object.entries(errors).forEach(([field, messages]) => {
        const errorElement = form.querySelector(`[data-error-for="${field}"]`);
        const input = form.querySelector(`[name="${field}"]`);

        if (input) {
            input.classList.remove("border-gray-300", "bg-gray-50");
            input.classList.add("border-red-500", "bg-white");
        }

        if (errorElement) {
            const message = Array.isArray(messages) ? messages[0] : messages;
            errorElement.textContent = message;
            errorElement.title = message;
        }
    });
};

export { clearFormErrors, showFormErrors };
